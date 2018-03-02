---
title:  "Policies vs Reality: MediaConch's Policy Update"
date:   2016-10-04 20:00:00 CET
tags: MediaConch, Policies
---

# Policies vs Reality

One of the key requirements of the [PREFORMA Challenge](http://preforma-project.eu/the-challenge.html) is the creation of policy checkers to verify whether a file matches the acceptance criteria for long-term preservation by memory institutions. In MediaConch, the policy checker integrates a policy editor so that users may create, edit, and apply policies to their audiovisual collections. For example, a memory institution could create and apply a policy to say that media files should have a 4/3 aspect ratio or use FFV1 only in version 3 or greater and sort through files that adhere to that policy or not. MediaConch builds upon MediaInfo so the terminology of MediaInfo may be used to generate very specific policies. Initially one of our guiding use cases for the policy checker was audiovisual digitization, where a memory institution may create specifications (such as 10 bit video, stereo 24 bit audio, 25 frames per second, etc) and create a policy to help automate ensuring that digitized files are as expected.

However ... after setting up policies, testing it out, and gathering feedback, we realized that the policies allowed in MediaConch were too simple to express most preservation policies. Taking existing audiovisual policies from the community and trying to convert them into MediaConch policies led to roadblocks. Audiovisual collections, whether analog or digital, tend to have significant amounts of technical diversity and lots of "if this then that" and "option A or option B" logic. In sending a mix of NTSC and PAL videotapes to a digitization vendor, the policy for expected results may be not be as simple as:

- frame_rate = X
- frame_width = Y
- frame_height = Z

but require more complex and conditional logic in such a policy, such as

- frame_rate = 29.970 (NTSC) OR frame_rate = 25.000 (PAL)
- frame_width = 720
- frame_height = 486 (NTSC) OR frame_height = 576 (PAL)

However this logic still does not fully capture reasonable expectations as a video file with an NTSC frame rate and a PAL frame height is likely not what is expected. With an additional layer of logic, the same policy can be clarified as:

- frame_width = 720
- ( frame_rate = 29.970 AND frame height = 486 ) OR ( frame_rate = 25.000 AND frame_height = 576 )

Accomplishing a sanity check on frame rates, frame widths, and frame heights starts to require some more complex logic if some of those values are intended to be conditional or grouped. The new MediaConch policy expression outlines this expression in XML like this:

~~~ xml
<policy type="and">
  <rule value="Width" tracktype="Video" operator="=">720</rule>
  <policy type="or">
    <policy type="and">
      <rule value="FrameRate" tracktype="Video" operator="=">25.000</rule>
      <rule value="Height" tracktype="Video" operator="=">576</rule>
    </policy>
    <policy type="and">
      <rule value="FrameRate" tracktype="Video" operator="=">29.970</rule>
      <rule value="Height" tracktype="Video" operator="=">486</rule>
    </policy>
  </policy>
</policy>
~~~

Here there are two entities: the policy and the rule. The `rule` is a test such as "Does the Video track's Height equal 486?" or "Is the Frame Rate of the Video track equal to 29.970?". Then the `policy` is a collection of rules and policies that are related with an "and" or "or". If the policy is an "and" type then the policy is true only if all the rules and policies that it contains are true, whereas an "or" policy is true if at least one of the rules and policies that it contains are true.

MediaConch adds some descriptors to rules and policies so that this is all better described. Such as:

~~~xml
<policy type="and" name="Is this NTSC or PAL SD?">
  <description>A test to see if the files use NTSC or PAL frame rates and sizes.</description>
  <rule name="Is Width at 720?" value="Width" tracktype="Video" operator="=">720</rule>
  <policy type="or" name="Is this NTSC SD or PAL SD?">
    <policy type="and" name="Is this PAL?">
      <rule name="PAL FrameRate" value="FrameRate" tracktype="Video" operator="=">25.000</rule>
      <rule name="PAL Height" value="Height" tracktype="Video" operator="=">576</rule>
    </policy>
    <policy type="and" name="Is this NTSC?">
      <rule name="NTSC FrameRate?" value="FrameRate" tracktype="Video" operator="=">29.970</rule>
      <rule name="NTSC Height?" value="Height" tracktype="Video" operator="=">486</rule>
    </policy>
  </policy>
</policy>
~~~

Fortunately, MediaConch provides an interface to help create policies, add rules, express conditions, but still we wanted to show what's happening behind the scenes and how MediaConch now manages an expression of policy.

![MediaConch's Policy Editor](/bundles/mediaconch/img/MediaConch_policy1.png)

MediaConch provides a few demo policies that demonstrate what's possible with the new version of the policy checker. If you have a policy that you'd like to see shared with MediaConch or need help expressing a policy through the policy editor, feel welcome to contact us via the [issue tracker](https://github.com/MediaArea/MediaConch_SourceCode/issues).
