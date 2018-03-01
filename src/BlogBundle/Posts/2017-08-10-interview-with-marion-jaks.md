---
title:  "Interview with Marion Jaks"
date:   2017-08-10
tags: mediaconch, interview
---

# Interview with Marion Jaks

*Editor's note: This is the fourth in a series of interviews with people using MediaConch within their institutions. You can find and read the previous entries [here](https://mediaarea.net/MediaConch/blog.html).*

![Marion at work](/bundles/mediaconch/img/marion.jpg)  
*Marion at work*

**Hey Marion! Introduce yourself please.**  

Hey Ashley! I am a video archivist at the [Austrian Mediathek](https://www.mediathek.at/) (Österreichischer Mediathek), the Austrian video and sound archive. My main area of work is the digitization of analogue videos and quality control of video files entering our digital archive. Since in the recent years more and more digital content is added to our collection, the dealing with digital files from various sources is becoming a growing part of my job.

**What does your media ingest process look like? Does your media ingest process include any tests (manual or automated) on the incoming content? If so, what are the goals of those tests?**  

The Austrian Mediathek started with digitizing its audio collection in the year 2000 and its video collection in the year 2010. Since our analogue collection is still growing there is still an ongoing digitization demand at the Mediathek and we will continue our in-house digitization efforts. Therefore, the biggest share of ingested files to our digital archive are produced in the in-house digitization department. The digitization systems for audio and video both have quality control steps implemented. One main goal of quality control in our institution is to detect artifacts and to find out which artifacts are due to problems during the digitization process and can be undone through certain actions. Both digitization workflows have steps implemented where file metadata is read out, so that the operator can control if the right settings were used. In [DVA-Profession](https://www.mediathek.at/digitalisierung/dva-profession-engl/), which we use for our video digitization workflow, [ffprobe](https://ffmpeg.org/ffprobe.html) is used to provide the metadata. This is in my opinion an essential check because it can prevent human error. In digitization we all work with presets that determine the settings of the capture procedure, but still it can happen that someone presses the wrong button…

So in my opinion, for quality control of digitization processes the main questions are: is the digital file a proper representation of the analogue original? And is the produced file meeting all requirements of a proper archive master file? And for the latter MediaConch is a great help for archivists.

**Where do you use MediaConch? Do you use MediaConch primarily for file validation, for local policy checking, for in-house quality control, for quality testing for vendor files?**  

 In our institution the main use case for MediaConch are files that were produced outside of the default workflow procedure. For example, when we edit clips from already digitized videos, I use MediaConch to easily find out if the files meet the policy for our archival master.

**At what point in the archival process do you use MediaConch?**  

I use MediaConch when receiving files that were produced outside of our regular workflows where other checks are already implemented in the system. At the moment this the case for files that were processed using editing software. At the Austrian Mediathek we are aiming to make as much of our digital (digitized) collection accessible to the public as possible. Due to rights issues often only parts of the videos are allowed to be published online – that’s where we need to produce special video clips. Those video clips are exported as an archive master in FFV1 so that we can easily produce further copies of the clips in the future. When we are planning a launch of a new project website those clips can easily count a few hundred. MediaConch is very helpful when there are a lot of files to check if all the export settings were set correctly – it saves a lot of time to check the files before any further work is done with them.

**Do you use MediaConch for MKV/FFV1/LPCM video files, for other video files, for non-video files, or something else?**  

We use MediaConch to check if produced video files meet the criteria of our archive master settings. In 2010 our decision for an archival master was to produce FFV1/PCM in an AVI-container. In the near future we are thinking of changing the container to MKV. Peter Bubestinger published the policy of the Austrian Mediathek’s archival master copies: [https://mediaarea.net/MediaConchOnline/publicPolicies](https://mediaarea.net/MediaConchOnline/publicPolicies)

**Why do you think file validation is important?**  

I think the most central point in archiving is being in control of your collection. In regards of a digital collection this means to know what kind of files you got and in what state they are in. With a growing digital collection, you will get all kinds of files in different codecs and containers. At the Austrian Mediathek we collect video and audio files from different institutions, professionals as well as private people – so our collection is very diverse and there is no way that we can prescribe any delivery conditions for files entering our institutions. Most of the donors of content do not know much about file formats, codecs, containers. At first I found it very surprising that even film/video professionals often cannot tell you what codec they use for their copies – after some years it is the other way round and I am impressed when filmmakers can tell me specifics about their files.

With this in mind the first step when receiving a digital collection is to find out what kind of files they are. Files that do not have a longer term perspective (e. g. proprietary codecs) should be normalized using a lossless codec like FFV1. With a very diverse collection file transcoding can be a demanding task, when your goal is to make sure that all features of the original are transferred to the archival master copy. Since we all are not immune to human error there must be checks implemented to make sure newly produced archival masters meet the defined criteria. Otherwise you can never be sure about your digital collection and therefore lost control over your archive: every archivist’s nightmare.

**Anything else you'd like to add?**  

I think that MediaConch fully unfolds its abilities in the quality control of files produced by digitization vendors. A few years ago we did outsource the digitization of 16mm film material. I was involved in the quality control of the produced files. At that time MediaConch was not around and the simple checks if the digitized files met the criteria of e. g. codecs/container were very time consuming. Nowadays MediaConch makes tasks like that so much easier and faster. I also like very much that MediaConch has a great, easy to use GUI so that colleagues not used to using the command line can easily do file validation checks. Thank you very much for the great work you are doing at MediaConch!

**Thanks Marion! For more from the Mediathek, check out their [audio/video web portal](https://www.mediathek.at/portalsuche/)!**
