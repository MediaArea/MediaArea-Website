---
title:  "Using QtWebEngine on the Mac App Store"
date:   2018-02-14 16:00:00 CET
excerpt: "Building an QtWebEngine-based app for the Mac App Store is not easy, below are the modifications we have made to Qt 5.8 in order to have our QtWebEngine-based app validated by Apple."
tags: MediaConch, Mac App Store
---

# Using QtWebEngine on the Mac App Store

Building an QtWebEngine-based app for the Mac App Store is not easy, below are the modifications we have made to Qt 5.8 in order to have our QtWebEngine-based app ([MediaConch](//itunes.apple.com/app/mediaconch/id1183720451)) validated by Apple.

In theory QtWebEngine is compatible with the Apple Mac Store since Qt5.7 with only a rebuild, but due to changes in the Chromium library code and the Apple Mac Store rules, rebuild is currently not sufficient even for the Qt5.9 LTS release.

We used Qt 5.8 because we want to keep the support of macOS 10.9, we did not test (yet) with Qt 5.9 LTS.

As a prerequisite, you need to install the Qt source code, this can be done from the MainenanceTool application in your Qt directory.

## Entitlements

You need an entitlements file with the following content (in addition of the one of the main application) for signing the QtWebEngineProcess application:

```
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
	<key>com.apple.security.app-sandbox</key>
	<true/>
	<key>com.apple.security.inherit</key>
	<true/>
</dict>
</plist>
```

## Application Group

QtWebEngine communicate with the  underlying Chromium process using mach port. Sandbox allow using mach ports only if an applications group is declared on the entitlements file (the one of the main application) and the name of this applications group must begin with your Apple TeamID followed by one period.

- Add the following key to your main application entitlements file:

```
	<key>com.apple.security.application-groups</key>
	<array>
		<string>XXXXXXXXXX.yyyy-group</string>
	</array>
```

- Edit the file ```qtwebengine/src/3rdparty/chromium/base/mac/foundation_util.mm``` and replace:

```
#if defined(GOOGLE_CHROME_BUILD)
  return "com.google.Chrome";
#else
  return "org.chromium.Chromium";
#endif
```

By:

```
  return "XXXXXXXXXX.yyyy-group";
```

In the both files, replace the "X" with your Apple TeamID and the "y" by anythings you want (e.g. the application name).

## QtWebEngineProcess Path

For finding the QtWebEngineProcess binary, the QtWebEngineCore framework uses paths relative to the bundle directory.
And for validating on the Apple Mac Store, all frameworks and helpers have to share the same bundle id as the main application.

So path calculation must be done relative to the main application directory and not the framework one.

- First, in the file ```qtwebengine/src/core/web_engine_library_info.cpp``` find the hardcoded bundle id "org.qt-project.Qt.QtWebEngineCore" and replace it by the blundle id of your application.

- In the same file change the following line:

```
    path = QString::fromCFString(bundlePath);
```

By:

```
    path = QString::fromCFString(bundlePath) % QLatin1String("/Contents/Frameworks/QtWebEngineCore.framework");
```

And the following lines:

```
     if (qApp->applicationName() == QLatin1String(QTWEBENGINEPROCESS_NAME)) {
         path = getPath(frameworkBundle) % QLatin1String("/Resources");
     } else if (frameworkBundle) {
         CFURLRef resourcesRelativeUrl = CFBundleCopyResourcesDirectoryURL(frameworkBundle);
         CFStringRef resourcesRelativePath = CFURLCopyFileSystemPath(resourcesRelativeUrl, kCFURLPOSIXPathStyle);
         path = getPath(frameworkBundle) % QLatin1Char('/') % QString::fromCFString(resourcesRelativePath);
         CFRelease(resourcesRelativePath);
         CFRelease(resourcesRelativeUrl);
     }
```

By:

```
     path = getPath(frameworkBundle) % QLatin1String("/Resources");
```

## Sandbox

Recent Chromium versions activate the sandbox on the fly, but since the application is already sandboxed this cause conflict.

- For disabling sandbox in the Chromium process replace the following lines in the file ```qtwebengine/src/core/web_engine_context.cpp```:

```
    bool disable_sandbox = qEnvironmentVariableIsSet(kDisableSandboxEnv);
```

By:

```
     bool disable_sandbox = true;
```

## Reserved API

At this point everything is working, but Apple Mac Store still complains about reserved API calls.

These API calls are in the sandboxing part we disabled just now, so it safe to remove them.

- In the file ```qtwebengine/src/3rdparty/chromium/sandbox/mac/launchd_interception_server.cc``` remove the lines:

```
   if (xpc_launchd_) {
     // xpc_dictionary_set_mach_send increments the send right count.
     xpc_dictionary_set_mach_send(request.xpc, "domain-port",
                                  sandbox_->real_bootstrap_port());
   }
```

- In the file ```qtwebengine/src/3rdparty/chromium/sandbox/mac/os_compatibility.cc``` remove the line:

```
     xpc_dictionary_set_mach_send(message.xpc, "port", service_port);
```

- In the file ```qtwebengine/src/3rdparty/chromium/sandbox/mac/pre_exec_delegate.cc``` remove the line:

```
     xpc_dictionary_set_mach_send(dictionary, "domain-port", MACH_PORT_NULL);
```

And replace the lines:

```
  if (is_yosemite_or_later_) {
    xpc_dictionary_set_mach_send(look_up_message_, "domain-port",
        bootstrap_port);

    // |pipe| cannot be created pre-fork() since the |bootstrap_port| will
    // be invalidated. Deliberately leak |pipe| as well.
    xpc_pipe_t pipe = xpc_pipe_create_from_port(bootstrap_port, 0);
    xpc_object_t reply;
    int rv = xpc_pipe_routine(pipe, look_up_message_, &reply);
    if (rv != 0) {
      return xpc_dictionary_get_int64(reply, "error");
    } else {
      xpc_object_t port_value = xpc_dictionary_get_value(reply, "port");
      *out_port = xpc_mach_send_get_right(port_value);
      return *out_port != MACH_PORT_NULL ? KERN_SUCCESS : KERN_INVALID_RIGHT;
    }
  } else {
    // On non-XPC launchd systems, bootstrap_look_up() is MIG-based and
    // generally safe.
    return bootstrap_look_up(bootstrap_port,
        sandbox_server_bootstrap_name_ptr_, out_port);
  }
```

By:

```
    return bootstrap_look_up(bootstrap_port, sandbox_server_bootstrap_name_ptr_, out_port);
```

- In the file ```qtwebengine/src/3rdparty/chromium/sandbox/mac/seatbelt.cc``` remove the lines:

```
 int sandbox_init_with_parameters(const char* profile,
                                  uint64_t flags,
                                  const char* const parameters[],
                                  char** errorbuf);
```

And replace the line:

```
   return ::sandbox_init_with_parameters(profile, flags, parameters, errorbuf);
```

By:

```
   return ::sandbox_init(profile, flags, errorbuf);
```

- In the file ```qtwebengine/src/3rdparty/chromium/sandbox/mac/xpc.h``` remove the lines:

```
 void xpc_dictionary_set_mach_send(xpc_object_t dictionary,
                                   const char* name,
                                   mach_port_t port);
```

And the line:

```
 mach_port_t xpc_mach_send_get_right(xpc_object_t value);
```

## QtWebEngine Rebuild

- Now rebuild QtWebEngine, type the following command in the qtwebengine src directory:

```
qmake WEBENGINE_CONFIG+=use_appstore_compliant_code
make
```

- Copy the lib/QtWebEngine.framework lib/QtWebEngineCore.framework and lib/QtWebEngineWidgets.framework directories to your Qt lib directory (e.g. ~/Qt/5.8/clang_64/lib).

## App Bundle and Signature

- Before building your application, dont forget to load your personalised Info.plist in your qmake project file ```QMAKE_INFO_PLIST = Info.plist```

- Deploy Qt bundle in your app directory:

```
macdeployqt MyApp.app -appstore-compliant
```

- Replace bundle id in all Info.plist files by your application bundle id:

```
find MyApp.app -name Info.plist -exec plutil -replace CFBundleIdentifier -string "com.MyCompagny.MyApp" {}\;
```

- Remove old signature directories:

```
find MyApp.app -name _CodeSignature -exec rm -fr {} \;
```
- Sign QtWebEngineProcess binary with your Mac Developper Signature:

```
codesign --force --verbose --sign "3rd Party Mac Developer Application: MyCompagny" MyApp.app/Contents/Frameworks/QtWebEngineCore.framework/Helpers/QtWebEngineProcess.app/Contents/MacOS/QtWebEngineProcess
```

- Sign QtWebEngineProcess bundle using the entitlements file we created earlier

```
codesign --deep --force --verbose --sign "3rd Party Mac Developer Application: MyCompagny" --identifier "com.MyCompagny.MyApp" --entitlements QtWebEngineProcess.entitlements MyApp.app/Contents/Frameworks/QtWebEngineCore.framework/Helpers/QtWebEngineProcess.app
```

- Sign all the frameworks:

```
for FRAMEWORK in $(ls MyApp.app/Contents/Frameworks | grep framework | sed 's/\.framework//') ; do
    codesign --force --verbose --sign "3rd Party Mac Developer Application: MyCompagny" -i com.MyCompagny.MyApp MyApp.app/Contents/Frameworks/$FRAMEWORK.framework/Versions/5/$FRAMEWORK
done
```

- Sign the dylib files:

```
find MyApp.app/Contents/PlugIns -name "*.dylib" -exec codesign --force --verbose --sign "3rd Party Mac Developer Application: MyCompagny" -i com.MyCompagny.MyApp '{}' \;
```

For all the commands before, dont forget to replace application name, bundle id and mac developer signature with yours.

***

If you have comments you can [contact us](/Contact) and if you have some improvements to suggest you can [fork our website repository then send us a patch](https://github.com/MediaArea/MediaArea-Website).
