---
title:  "MediaConch Displays: Simple and CSV"
date:   2016-10-05
tags: MediaConch, Policies
---

---

# MediaConch Displays

In MediaConch, a "Display" is a transformation that creates a request report from a MediaConch XML. Internally when MediaConch applies a policy test or implementation test on a file it generates a MediaConch XML document which describes the results of those tests. In many cases, the user may not wish to see an XML document, so the "Displays" transform that data into more digestable forms, such as HTML or plain text.

Starting in the MediaConch 17.01 two new "Displays", Simple and CSV, are added that are particularly useful when using MediaConch with large sets of files. Whereas the HTML and plain text Displays will reveal all the details of the test results, Simple and CSV condense that result into a much more concise report.

## Simple

The Simple display will only be one line long if the test (either policy or implementation) passes. In this case the output will simply be:

```
pass! /Users/mediaconch/Desktop/important_movie.mkv
```

If the result of the policy on a particular file fails, then it will report the outcome and filename (similarly to how it looks as a pass), but will then add a list of what components of the policy or implementation failed. For instance, MediaConch includes a policy to see if a file adheres to [Memoriav's video file recommendations](https://github.com/MediaArea/MediaConch_SourceCode/blob/master/Tools/Policies/sample_policy_7_memoriav_recommendations.xml).

In this command the `-fs` or `--Format=simple` means to use to Simple display and `-p sample_policy_7_memoriav_recommendations.xml` means to test the files against that policy.

```
mediaconch -fs -p sample_policy_7_memoriav_recommendations.xml /Users/mediaconch/Desktop/some_random_file.mkv


fail! /Users/davidrice/Movies/lossless_vs_corruption.mov
   --  [fail:Memoriav Video files Recommendations]
   --   [fail:Recommended Video Encoding?]
   --    [fail:Format is 10 bit 4:2:2 uncompressed?]
   --     [fail:Format is YUV?]
   --     [fail:BitDepth is 10?]
   --    [fail:Format is 10 bit 4:4:4 uncompressed?]
   --     [fail:Format is YUV?]
   --     [fail:Chromasubsampling is 4:4:4?]
   --     [fail:BitDepth is 10?]
   --    [fail:Format is 8 bit 4:2:2 uncompressed?]
   --     [fail:Format is YUV?]
   --     [fail:BitDepth is 8?]
   --   [fail:Conditionally recommended Video Encoding?]
   --    [fail:Format is DV?]
   --    [fail:Format is JPEG 2000?]
   --    [fail:Format is FFV1?]
   --    [fail:Format is MPEG2 (XDCam 50 or IMX 50)?]
   --     [fail:Format is MPEG?]
   --     [fail:Format version is 2 (MPEG2)?]
   --     [fail:BitRate is 50Mb]
   --      [fail:BitRate is 50Mb?]
   --      [fail:Max BitRate is 50Mb?]
```

Here the tested file `some_random_file.mkv` fails nearly every test of the policy, so each fail is listed in the same hierarchical structure of the policy.

If a large number of files needs to be tested against a policy, this Display can make the outcome much easier to skim. For instance, [this policy](https://github.com/MediaArea/MediaConch_SourceCode/blob/master/Tools/Policies/sample_policy_1.xml) tests to see if a file comforms NTSC or PAL or if it doesn't.

```
mediaconch -fs -p sample_policy_1.xml importantvideo.mov final_movie.mkv probablypal.avi secret.webm

pass! importantvideo.mov
fail! final_movie.mkv
   --  [fail:Is this NTSC or PAL SD?]
   --   [fail:Is Width at 720?]
   --   [fail:Is Interlaced?]
   --   [fail:Is this NTSC SD or PAL SD?]
   --    [fail:Is this PAL?]
   --     [fail:PAL height]
   --    [fail:Is this NTSC?]
   --     [fail:NTSC FrameRate]
   --     [fail:NTSC Height]
   --      [fail:NTSC height]
   --      [fail:NTSC-ish height]
pass! probablypal.avi
pass! secret.webm
```

Here is it easy to see that one file, `final_movie.mkv`, fails the policy and a list of all the reasons why.

## CSV

The CSV Display is intended specifically for policy use. Here each of the first-level sub-policies or sub-rules of the policy become a column in a CSV and the output will generate a table that shows if the file passed or failed that component of the policy individually.

For instance the NTSC or PAL policy used above includes three first-level tests: is the width at 720 pixels, is the file interlaced, and does the file use sets of frame rates and frame sizes of either NTSC or PAL specifications. So if the above command is adjusted to use `-fc` (or `--Format=CSV`) rather than `-fs` for simple, such as:

```
mediaconch -fc -p sample_policy_1.xml importantvideo.mov final_movie.mkv probablypal.avi secret.webm
```

then the output will create a table in a CSV format.

~~~ csv
filename,"Is Width at 720?","Is Interlaced?","Is this NTSC SD or PAL SD?"
importantvideo.mov,pass,pass,pass
final_movie.mkv,fail,fail,fail
probablypal.avi,pass,pass,pass
secret.webm,pass,pass,pass
~~~

We welcome feedback or questions on these new features. Please feel welcome to email us at info@mediaarea.net or file an [issue on GitHub](https://github.com/MediaArea/MediaConch_SourceCode/issues).
