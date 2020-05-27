---
title:  "Announcing BWF MetaEdit 20.05!"
date:   2020-05-28 08:00:00 CET
excerpt: "Thanks to renewed support from the Library of Congress, MediaArea is proud to present a new and improved version of BWF MetaEdit"
tags: BWF MetaEdit
---

Announcing BWF MetaEdit 20.05!

Thanks to renewed support from the Library of Congress, MediaArea is proud to present a new and improved version of BWF MetaEdit, now [available for download](https://mediaarea.net/BWFMetaEdit). BWF MetaEdit is a tool that supports embedding, validating, and exporting of metadata in Broadcast WAVE Format (BWF) files. It also supports the FADGI Broadcast WAVE Metadata Embedding Guidelines. Improvements in this new version include single file form view, ability to toggle md5 endianness value, elimination of `CodingHistory` and `BextVersion` duplication bugs, a "Fill all open files with this value" option, and more. See the bottom of this announcement for a full list.

Bugs and new feature requests were identified through a series of interviews with BWF MetaEdit users. Huge thanks to the follow interviewees for their time and insight:

*   Bryan Hoffa and Robert Friedrich from the [Library of Congress National Audio-Visual Conservation Center](https://www.loc.gov/programs/audio-visual-conservation/about-this-program/)
*   Bryce Roe, Julia Hawkins, Chris Heaney, and Karl Fleck from the [Northeast Document Conservation Center](https://www.nedcc.org/)
*   Kira Sobers and Dave Walker from the [Smithsonian Institution Archives](https://siarchives.si.edu/)
*   Marcos Sueiro Bal and Daniel Sbardella from [WNYC Archives](https://www.wnyc.org/)
*   Courtney Egan, Ryan Davis, Jessie Sims, and Jerry Jackson from the [National Archives and Records Administration Audio-Video Preservation Lab](https://www.archives.gov/preservation)

BWF MetaEdit users are encouraged to provide feedback or follow along with updates via our [GitHub Issues Tracker](https://github.com/MediaArea/BWFMetaEdit/issues). MediaArea produces daily builds of the latest release, available [here](https://mediaarea.net/download/snapshots/binary/bwfmetaedit-gui/) and arranged by date and operating system. To get the latest snapshot, navigate to your operating system version and download the installer file. More updates are planned based on feedback from this release, with an anticipated late summer release. Your feedback will help make this software better!

This version includes the following improvements:

*   GUI: Bug fix: Fix compilation issues with non-Unicode on Windows (Issue [#135](https://github.com/MediaArea/BWFMetaEdit/issues/135))
*   GUI: Bug fix: Improve ASCII support (Issue [#29](https://github.com/MediaArea/BWFMetaEdit/issues/29), [#63](https://github.com/MediaArea/BWFMetaEdit/issues/63))
*   GUI: Feature: 'Fill all open files with this' option (Issue [#110](https://github.com/MediaArea/BWFMetaEdit/issues/110))
*   GUI: Bug fix: Add line breaks in FileName field descriptions (Issue [#121](https://github.com/MediaArea/BWFMetaEdit/issues/121))
*   GUI: Feature: Toggle md5 value endianness (Issue [#78](https://github.com/MediaArea/BWFMetaEdit/issues/78))
*   GUI: Bug fix: Fix duplication of CodingHistory headers (Issue [#103](https://github.com/MediaArea/BWFMetaEdit/issues/103))
*   GUI: Feature: Show tooltips only over column headers (Issue [#99](https://github.com/MediaArea/BWFMetaEdit/issues/99))
*   GUI: Bug fix: Stop setting BextVersion field twice (Issue [#98](https://github.com/MediaArea/BWFMetaEdit/issues/98))
*   GUI: Bug fix: occasional crash when saving large number of files (Issue [#71](https://github.com/MediaArea/BWFMetaEdit/issues/71))
*   GUI: Feature: Incorporate logo (Issue [#76](https://github.com/MediaArea/BWFMetaEdit/issues/76))
*   GUI: Feature: Add single file editor view (Issue [#79](https://github.com/MediaArea/BWFMetaEdit/issues/79), [#127](https://github.com/MediaArea/BWFMetaEdit/issues/127), [#106](https://github.com/MediaArea/BWFMetaEdit/issues/106))
*   GUI: Bug fix: Improve file drag and drop events (Issue [#83](https://github.com/MediaArea/BWFMetaEdit/issues/83))
*   GUI: Bug fix: Improve CodingHistory dialog (Issue [#122](https://github.com/MediaArea/BWFMetaEdit/issues/122), [#124](https://github.com/MediaArea/BWFMetaEdit/issues/124))
*   GUI: Feature: Add icon to close files (Issue [#100](https://github.com/MediaArea/BWFMetaEdit/issues/100))
*   GUI: Feature: Show available info for invalid files (Issue [#93](https://github.com/MediaArea/BWFMetaEdit/issues/77))
*   GUI: Feature: Add warnings and use icons for errors/warnings (Issue [#101](https://github.com/MediaArea/BWFMetaEdit/issues/101))
*   GUI: Feature: Soften color palette (Issue [#126](https://github.com/MediaArea/BWFMetaEdit/issues/126))

If you are wondering about the dramatic number change, this is because MediaArea has shifted to using a year.month-based version numbering system. The number 20 represents the year 2020, and 05 represents the month of May. Subsequent releases will follow this pattern.
