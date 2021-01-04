---
title:  "Announcing RAWcooked 21.01!"
date:   2021-01-04 08:00:00 CET
excerpt: "Thanks to support from New York Public Library, MediaArea is proud to present a new and improved version of RAWcooked"
tags: RAWcooked
---

Announcing RAWcooked 21.01!

We're very grateful to announce that a new version of RAWcooked is now available. The 21.01 release introduces several new features and fixes that focus on ensuring that the full reversibility of RAWcooked files to their source files is verifiable, even if the source files are not later accessible. Often users were converting DPX to RAWcooked and then back to DPX to test the reversibility as a multi-step process and now those tests, along with many other conformance tests, are included as part of the RAWcooked process. We recommend updating to this version and offering any feedback directly to us or via GitHub.

Thanks tremendously for your sponsorship, encouragement, support and vision. RAWcooked has been a particularly fulfilling project as it's been a fully open-source project supported financially and spiritually by its community of users. From here we're continuing to work on a couple of features already in development: EXR support, error correction codes, luma only DPX, speedup improvements (decoder and encoder).

Example of output:
~~~
rawcooked --all 818_DCDM_P3_IA_FIC_000918
Track 1:
  818_OV/818_OV_%07d.dpx
 (0086945 --> 0088956)
  DPX/Raw/RGB/10bit/FilledA/BE
Track 2:
  818_OV_FR_ST/818_OV_FR_ST_%07d.dpx
 (0086945 --> 0088956)
  DPX/Raw/RGB/10bit/FilledA/BE
Track 3:
  818_TextlessBGD/818_TextlessBGD_%07d.dpx
 (0086160 --> 0088165)
  DPX/Raw/RGB/10bit/FilledA/BE
Track 4:
  audio/818_DCP_5point1.wav
  WAV/PCM/48kHz/24bit/6ch/LE
Track 5:
  audio/818_Stereo_LtRt.wav
  WAV/PCM/48kHz/24bit/2ch/LE

Warning: non-conforming DPX Ditto key.
Warning: non-conforming computed hashes are not same as hashes in hash files.
       818_DCDM_P3_IA_FIC_000918/818_OV/818_OV_0086956.dpx
At least 1 file is not conform to specifications.

Do you want to continue despite warnings? [y/N] y

[FFmpeg logs]

Info: Reversibility data created by RAWcooked 21.01.
Info: Uncompressed file hashes (used by reversibility check) present.
Info: 1 hash file (used by conformance check) found.

Reversability was checked, no issue detected.
~~~

~~~
$ rawcooked --info --check --conch 818_DCDM_P3_IA_FIC_000918.mkv
3.7 MiB/s, 0.78x realtime

Info: Reversibility data created by RAWcooked 21.01.
Info: Uncompressed file hashes (used by reversibility check) present.
Info: 1 hash file (used by conformance check) found.

Reversability was checked, no issue detected.

Warning: non-conforming DPX Ditto key.
Warning: non-conforming computed hashes are not same as hashes in hash files.
       818_DCDM_P3_IA_FIC_000918/818_OV/818_OV_0086956.dpx
At least 1 file is not conform to specifications.
~~~


Below are the release notes of the released version:

*   Thanks to New York Public Library (NYPL) for their vision and support on this release
*   Thanks to British Film Institute (BFI) for their extensive testing
*   Reversibility checking: an option to check after encoding to ensure that the decoding of a RAWcooked file is fully reversible (--check)
*   Reversibility checking: an option to embed checksums of the input files  to enable the possibility of later reversibility integrity checks without requiring access to the original  input files (--hash)
*   Conformance checking: an option to to perform a selection of DPX implementation and MD5 hash file coherency checks (--conch), more to come
*   Coherency checking: an option to check e.g. that audio duration is same as video duration (--coherency, by default)
*   A new requirement when encoding DPX with padding bits to specify user preferences for the evaluation of padding bits (--check-padding or --no-check-padding) as some DPX files use padding bits for unstandardized purposes.
*   An option to offer extra information about the content of the reversibility data (--info)
*   Perform --info --check --hash --conch --coherency --check-padding --encode in a single option (--all)
*   Support additional post-encoding coherency checks, such as a quick check of the resulting compressed file in order to be sure that FFmpeg correctly finished the encoding.
*   Fix reversibility issues if DPX header does not have the same size in all files
*   Support of more DPX/TIFF/WAV/AIFF flavors and features

[Learn more and download RAWcooked](/RAWcooked).
