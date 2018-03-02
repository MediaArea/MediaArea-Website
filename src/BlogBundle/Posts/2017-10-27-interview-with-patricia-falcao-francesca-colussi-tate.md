---
title:  "Interview with Patricia Falcao and Francesca Colussi"
date:   2017-10-27
tags: MediaConch, Interview
---

# Interview with Patricia Falcao and Francesca Colussi of Tate  

*Editor's note: This is the seventh in a series of interviews with people using MediaConch within their institutions. You can find and read the previous entries [here](https://mediaarea.net/MediaConch/blog.html).*  

![](/bundles/mediaconch/img/tate.png)  

**Hey Patricia and Francesca! Introduce yourselves please.**  

PF: My name is Patricia Falcao and I am a time-based media conservator at Tate. I’ve had different roles within Time-based Media Conservation over the last 8 years, but most recently I have been responsible for the acquisition of new artworks into the collection. That means I work with a team of people to ensure that we have all the information, media, equipment and software that we need to preserve these works. This means I am very interested in checking that files that we receive from artists don’t have any issues that may impact their sustainability and playback and also that when we receive tapes and migrate their contents to file the resulting formats are consistent among themselves and with our specifications for our files.  

FC: My name is Francesca Colussi and I’m one of the senior time-based media conservation technicians at Tate. Within our department I am part of the team that installs and takes care of displays and exhibitions. I’ve been at Tate for a bit more than a year and I have a pretty eclectic professional background, ranging from art publishing to photography and video production. Before Tate I was managing the studio of a video artist, there I started to deepen my interest in video archiving, equipment researching and exhibition formats production. I have a special interest in analysing the dependencies between specific files, software and hardware, especially in video production. Media encoding is a key part of our workflow and my colleagues and I try to make sure we have the ideal exhibition format to perfectly match the equipment we use for each display and exhibition.  

**What does your media ingest process look like? Does your media ingest process include any tests (manual or automated) on the incoming content? If so, what are the goals of those tests?**  

There are two different types of ingest;  
1- Material that we have or receive as tape, which we must migrate to file and  
2- Videos which we receive as file, either because they were produced as file (often on some flavour of QuickTime/ProRes) or in some cases it is tape-based video transferred at some other institution or by the artist.  

Compared to AV archives we receive a small number of files, typically under 100 files/year, but they are all part of extremely valuable artworks that Tate has to preserve for the long-term.  

We transfer our tapes in external facilities, and we are always present for the transfers, so we can do an initial quality control at that point. We would look for image errors and try to identify if they are on the tape or if they were caused by the transfer. At this stage we would also check the resulting files with MediaConch to see if the files being produced are what we requested. Further to that we would want to be sure that the content of any file (both from tape and born-digital) is what is meant to be, so that we have the right artwork, only the right artwork and all of the artwork. We also need to look for image errors and understand whether they are intended or are there by mistake. We found that we usually will look at the video for any flaws and in parallel look at the file in QCTools. We are still learning to use QCTools to its full potential. We are growing in confidence on the tool and our ability to use it, but we also still want to look at the total duration of the videos. We look at the video files in 3 players, typically QuickTime 7, VLC and QCTools, the first pass we look at the whole video and then we only sample the video in the 2 other players. This helps bring out issues with inconsistent metadata for aspect ratio, for example. We would also look at the metadata with MediaInfo, and make sure that what we received is what we expected. This sometimes also allows us to identify issues with colour space or aspect ratio. We are also seeing/hearing more and more complex audio tracks, from 5.1 to 9.1 and we have started to use audacity to check those.  

These checks are usually done on the files in our Interim Storage, which we copy over from the artist supplied hard-drive using either [Exactly](https://www.avpreserve.com/products/exactly/) (from AVPreserve) or [Bagger](https://www.loc.gov/preservation/digital/) (from the LoC), which creates all the checksums in a bag. Once the checks above are made we will then use [Archivematica](https://www.archivematica.org/en/) to transfer to our Archival Storage, but that is currently still in the testing phase.  

**Where do you use MediaConch? Do you use MediaConch primarily for file validation, for local policy checking, for in-house quality control, for quality testing for vendor files?**  

PF: As I said above, in my context we use MediaConch to check files that have resulted from migration. We usually have one or two migration sessions a year, and MediaConch makes comparing those files among themselves and with specifications a lot easier. Dave Rice analysed the specifications for QuickTime wrapper/V210 compression and created a profile for us that has already raised a series of questions about our processes and is making us reconsider how to transfer from tape to file.  

FC: I mainly use MediaConch as a comparison and ‘problem solving’ tool to spot anomalies in exhibition format files, therefore I would say I use it both for local policy checking and in-house quality control. Our Exhibition Files are specifically produced each time we are preparing a work to be displayed and when encoding a video file for an exhibition we need to comply to the media player settings (in our case mainly Brightsign) and take in consideration the projector we are going to use. Sometimes unexpected problems occur like playback issues, glitches or simply the player being unable to read the file. The first step is always to check the file visually if it’s a video, but then a multiple set of tools is necessary to have a deeper understanding of the issues.  

MediaConch is particularly useful when I prepare files for multiple channel installations that originally have the same or similar properties. For example if we use the same setting to encode all the files and some of them appear faulty I use MediaConch to create a local policy and spot the issues. Sometimes it’s challenging as the rules of dependency between equipment and files vary and Dave Rice helped us exploring the possibility to develop a specific policy to check the files against the Brightsign specs which I find a very interesting challenge.  

**At what point in the archival process do you use MediaConch?**  

PF: We would usually use MediaConch either when we receive new files, before preparing an AIP/Bag for storage or after a migration from Tape to file.  

**Do you use MediaConch for MKV/FFV1/LPCM video files, for other video files, for non-video files, or something else?**  

PF: So far we’ve used it for QuickTime files with either V210, ProRes, DV or H.264 compression, but also for other video files, like MPEG-1/2 Video.  

FC: I mainly use it for video or sound files, ProRes, H.264 and MPEG-1/2 Video are the most common files I handle.  

**Why do you think file validation is important?**  

PF: Because it will highlight any issues that a file may have that may not be immediately visible in the image or even the metadata but that may impact a file’s sustainability in the long-term.   

FC: I totally agree with Patricia. The previous step in validation done during the acquisition process makes sure we have an issues free master file to refer to when producing any exhibition formats.  

**Anything else you'd like to add?**

PF: over the last few years, through the collaboration with Dave Rice and tool developers we have been completely sold to using open source tools for our archiving workflows. It is such an impressive community working in this field. Congratulations!  

*Thanks so much! For more from Tate, see this whitepaper on [Audiovisual Adherence](http://www.tate.org.uk/research/publications/audiovisual-adherence), co-authored with our own Dave Rice. The Tate team also recently produced a short video entitled Things Change: Conservation and Display of Time-based Media Art, available [here](http://www.tate.org.uk/about-us/projects/pericles/things-change-conservation-and-display-time-based-media-art), that explains their conservation process and includes MediaConch usage!*
