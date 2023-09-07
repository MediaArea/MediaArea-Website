---
title:  "RAWcooked and risk of non reversibility, update to v23.09+ recommended"
date:   2023-09-07 17:00:00 CET
excerpt: "We discovered a possible edge case for non-reversibility when using RAWcooked on some forms of corrupt DPX/TIFF/EXR files (specifically when the first four bytes are not the magic number of that format). We recommend updating to the last RAWcooked release (23.09+) to avoid this risk."
tags: RAWcooked
---

Short version:  
We discovered a possible edge case for non-reversibility when using RAWcooked on some forms of corrupt DPX/TIFF/EXR files (specifically when the first four bytes are not the magic number of that format). We recommend updating to the last RAWcooked release (23.09+) to avoid this risk.

Longer version:  
For us transparency matters and we prefer to inform you of any risk, even very unlikely, of a breach in our commitment of reversibility with RAWcooked.

There is a loss of content in an uncommon situation that applies only to DPX/TIFF/EXR sequences that contain a file where the first 4 bytes are not as expected (e.g. a DPX file where the first four bytes are not the “XPDS” magic value). Such a file is not decodable by any DPX/TIFF/EXR reader, but such invalid files could happen to be within such image sequences. For such a file, a RAWcooked encoding (for versions before 23.09) completely skips the invalid file so it is not represented in the resulting RAWcooked compressed file. For instance, with this sequence:  
image_001.dpx (valid)  
image_002.dpx (first four bytes are not 0x58504453, aka "XPDS" in ascii)  
image_003.dpx (valid)  
the resulting RAWcooked compressed file would only depict image_001.dpx and image_003.dpx, even though image_002.dpx may contain valid image data. Decoding that resulting RAWcooked compressed file would not recreate the original image_002.dpx file.

As noted, this issue only appears when the 4 first bytes are not the file format magic value. In the report we received that identified this issue, 1 file in the sequence had the first 512 bytes filled with zeros. As far as we know any other malformed file is detected and causes RAWcooked to exit with an error message. It is also fine if the first file of a sequence is corrupted as it would be managed as an attachment.

The reason of the RAWcooked failure is in how RAWcooked (for versions before 23.09) and the library used for compression (FFmpeg) handle such kind of file:
- the prescan of the files made by RAWcooked failed to report an error if the 4 first bytes are invalid. Such an invalid file would be ignored (unstored and unrepresented in the RAWcooked reversibility file),
- FFmpeg outputs an error in its logs but considers the output as fine enough for not emitting an error (FFmpeg exit code is 0), the file is also ignored,
- even with “ --check” or “ --all”, the issue is not caught due to the match between RAWcooked behavior and FFmpeg behavior, except if you have a MD5 file (in that case, a mismatch between the MD5 file and the list of files is detected).

We managed the issue by:
- Fixing RAWcooked code for throwing an error if the 4 first bytes are not the file format magic value so such malformed file is detected during prescan, as well as checking that there is no other silent discard of a corrupted file in our code,
- Adding “ -xerror” flag to FFmpeg so any FFmpeg error message is considered as important enough for stopping the compression and exiting with an error exit code, in order to avoid any other similar case in the future.

About catching the issue in already compressed content:  
If you stored the logs, you can look for “DPX marker not found” or “Error while decoding stream #0:0: Invalid data found when processing input” which would indicate that this event had occurred. Otherwise, you could note if there's a file number missing in the sequence; however, sometimes missing file numbers could be intentional, though that requires the "--accept-gaps” option to avoid RAWcooked reporting the error. If you find such instances or would like help identifying such instances, please contact us.

A big user of RAWcooked checked its RAWcooked logs, and a rough estimation of the occurrence of such an issue is 0.1% of packages impacted, with an average of 1 (buggy) file lost per package.

[Learn more and download RAWcooked](/RAWcooked).
