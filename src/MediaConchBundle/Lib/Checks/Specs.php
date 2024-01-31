<?php

namespace MediaConchBundle\Lib\Checks;

use MediaConchBundle\Lib\Checks\Checks;

class Spec
{
    public $latest;
    public $shortName;
    public $longName;
    public $paywall;
    public $website;
    public $abstract;
    public $elements;
    public $flags;
    
    public function __construct($latest = null, $shortName = null, $longName = null, $paywall = null, $website = null, $abstract = null, $elements = null, $flags = null)
    {
        $this->latest = $latest;
        $this->shortName = $shortName;
        $this->longName = $longName;
        $this->paywall = $paywall;
        $this->website = $website;
        $this->abstract = $abstract;
        $this->elements = $elements;
        $this->flags = $flags;
    }
}

class Element
{
    public $description;
    public $fields;
    public $deepLink;
    
    public function __construct($description = null, $fields = null, $deepLink = null)
    {
        $this->description = $description;
        $this->fields = $fields;
        $this->deepLink = $deepLink;
    }
}

class Field
{
    public $description;
    
    public function __construct($description = null)
    {
        $this->description = $description;
    }
}

//
$GLOBALS['dbSpecs'] =
[
    'ETSI_TS_102_114' => new Spec(
        ' 1.6.1',
        'DTS / DTS-HD',
        'DTS Coherent Acoustics; Core and Extensions with Additional Profiles',
        false,
        '//www.etsi.org/standards#page=1&search=102%20114&etsiNumber=1&content=0',
        'The present document describes the key components of the DTS Coherent Acoustics technology which is known in the market as DTS-HD™. Prior editions of the present document added Annexes describing stream encapsulations of the bitstreams defined herein for MPEG-2 Transport Stream (based on ISO/IEC 13818-1) and ISO Based Media Files (using ISO/IEC 14496-12 [5]). This edition has been extended with two new Annexes that describe particular methods of network distribution of the defined bitstreams using MPEG-DASH (ISO/IEC 23009-1 [3]) and MPEG-CMAF (ISO/IEC 23000-19 [4]).',
        [
            'CoreFrameHeader' => new Element(
                null,
                [
                    'SFREQ' => new Field(
                        'Core Audio Sampling Frequency [...] sample rate according to Table 4.1'
                    ),
                ]
            ),
        ]
    ),
    'ETSI_TS_102_366' => new Spec(
        ' 1.4.1',
        'AC-3 / E-AC-3',
        'Digital Audio Compression (AC-3, Enhanced AC-3) Standard',
        false,
        '//www.etsi.org/standards#page=1&search=102%20366&etsiNumber=1&content=0',
        'The present document specifies two coded representations of audio information, and specifies the decoding process for each coded representation. Informative information on the encoding process is included. The coded representations specified herein are suitable for use in digital audio transmission and storage applications. The coded representations may convey multiple full bandwidth audio signals, along with a low frequency enhancement signal. A wide range of encoded bit-rates is supported by the present document.',
        [
            'syncframe/syncinfo' => new Element(
                null,
                [
                    'fscod' => new Field(
                        'sampling frequency code [...] sample rate according to Table 4.1'
                    ),
                ]
            ),
            'syncframe/bsi' => new Element(
                null,
                [
                    'fscod' => new Field(
                        'sampling frequency code [...] sample rate according to Table E.1.2'
                    ),
                ]
            ),
            'AC3SpecificBox' => new Element(
                null,
                [
                    'fscod' => new Field(
                        'sampling frequency code [...] same meaning and shall be set to the same value as the fscod field in the AC-3 bitstream'
                    ),
                ]
            ),
            'EC3SpecificBox' => new Element(
                null,
                [
                    'fscod' => new Field(
                        'sampling frequency code [...] same meaning and shall be set to the same value as the fscod field in the independent substream'
                    ),
                ]
            ),
        ]
    ),
    'ISO_IEC_14496-1' => new Spec(
        ':2019',
        'MPEG-4 Systems',
        'Information technology — Coding of audio-visual objects — Part 1: Systems',
        true,
        '//www.iso.org/standard/55688.html',
        'This document specifies system level functionalities for the communication of interactive audio-visual scenes, i.e. the coded representation of information related to the management of data streams (synchronization, identification, description and association of stream content).',
        [
            'moov/iods' => new Element(
                'This object contains an Object Descriptor or an Initial Object Descriptor'
            ),
            'InitialObjectDescriptor' => new Element(
                'The InitialObjectDescriptor is a variation of the ObjectDescriptor specified in the previous subclause that allows to signal profile and level information for the content referred by it. It shall be used to gain initial access to ISO/IEC 14496 content',
                [
                    'audioProfileLevelIndication' => new Field(
                        'an indication as defined in Table 5 of the audio profile and level required to process the content associated with this InitialObjectDescriptor'
                    ),
                ]
            ),
        ]
    ),
    'ISO_IEC_14496-3' => new Spec(
        ':2019',
        'MPEG-4 Audio',
        'Information technology — Coding of audio-visual objects — Part 3: Audio',
        true,
        '//www.iso.org/standard/76383.html',
        'This document integrates many different types of audio coding: natural sound with synthetic sound, low bitrate delivery with high-quality delivery, speech with music, complex soundtracks with simple ones, and traditional content with interactive and virtual-reality content. This document standardizes individually sophisticated coding tools to provide a novel, flexible framework for audio synchronization, mixing, and downloaded post-production.<br>This document does not group a single application such as real-time telephony or high-quality audio compression. Rather, it applies to every application requiring the use of advanced sound compression, synthesis, manipulation, or playback. This document specifies the state-of-the-art coding tools in several domains. As the tools it defines are integrated with the rest of the ISO/IEC 14496 series, exciting new possibilities for object-based audio coding, interactive presentation, dynamic soundtracks, and other sorts of new media, are enabled.',
        [
            'AudioSpecificConfig' => new Element(
                null,
                [
                    'audioObjectType' => new Field(
                    ),
                    'channelConfiguration' => new Field(
                        'audio output channel configuration (in case of PS, this is the output channel configuration without PS)'
                    ),
                    'extensionChannelConfiguration' => new Field(
                        'audio output channel configuration (in case of PS)'
                    ),
                    'extensionSamplingFrequency' => new Field(
                        'The sampling frequency used for this audio object (in case of SBR)'
                    ),
                    'samplingFrequency' => new Field(
                        'The sampling frequency used for this audio object (in case of SBR, this is the sampling frequency without SBR)'
                    ),
                ]
            ),
        ]
    ),
    'ISO_IEC_14496-12' => new Spec(
        ':2022',
        'MPEG-4 ISO base media file format',
        'Information technology — Coding of audio-visual objects — Part 12: ISO base media file format',
        true,
        '//www.iso.org/standard/83102.html',
        'This document specifies the ISO base media file format, which is a general format forming the basis for a number of other more specific file formats. This format contains the timing, structure, and media information for timed sequences of media data, such as audio-visual presentations.',
        [
            'moof/traf/trun' => new Element(
                'Track Fragment Run'
            ),
            'moof/traf/sbgp' => new Element(
                'Sample to Group',
                [
                    'group_description_index' => new Field(
                        'gives the index of the sample group entry which describes the samples in this group'
                    ),
                ]
            ),
            'moof/traf/sgpd_prol' => new Element(
                'Sample Group Description [...] AudioPreRoll',
                [
                    'roll_distance' => new Field(
                        'gives the number of samples that must be decoded in order for a sample to be decoded correctly'
                    ),
                ]
            ),
            'moov/trak/mdia/minf/stbl/sbgp' => new Element(
                'Sample to Group',
                [
                    'group_description_index' => new Field(
                        'gives the index of the sample group entry which describes the samples in this group'
                    ),
                ]
            ),
            'moov/trak/mdia/minf/stbl/sgpd_prol' => new Element(
                'Sample Group Description [...] AudioPreRoll',
                [
                    'roll_distance' => new Field(
                        'gives the number of samples that must be decoded in order for a sample to be decoded correctly'
                    ),
                ]
            ),
            'moov/trak/mdia/minf/stbl/stss' => new Element(
                'Sync Sample',
                [
                    'sample_number' => new Field(
                        'marking of the sync samples within the stream [...] If the sync sample box is not present, every sample is a sync sample'
                    ),
                ]
            ),
            'moov/trak/mdia/minf/stbl/stts' => new Element(
                'Decoding Time to Sample',
                [
                    'sample_count' => new Field(
                        'an integer that counts the number of consecutive samples that have the given duration'
                    ),
                ]
            ),
            'moov/trak/tkhd' => new Element(
                'Track Header',
                [
                    'track_ID' => new Field(
                        'an integer that uniquely identifies this track over the entire life‐time of this presentation'
                    ),
                ]
            ),
            'AudioSampleEntry' => new Element(
                null,
                [
                    'samplerate' => new Field(
                        'default samplerate of media'
                    ),
                ]
            ),
        ]
    ),
    'ISO_IEC_23003-3' => new Spec(
        ':2020',
        'USAC',
        'Information technology — MPEG audio technologies — Part 4: Dynamic range control',
        'true',
        '//www.iso.org/standard/75930.html',
        'This document specifies technology for loudness and dynamic range control. It is applicable to most MPEG audio technologies. It offers flexible solutions to efficiently support the widespread demand for technologies such as loudness normalization and dynamic range compression for various playback scenarios.',
        [
            'AudioPreRoll' => new Element(
                'Syntax of AudioPreRoll()',
                [
                    'auLen' => new Field(
                        'AU length in bytes'
                    ),
                    'configLen' => new Field(
                        'Size of the configuration syntax element in bytes'
                    ),
                    'numPreRollFrames' => new Field(
                        'The number of pre-roll access units (AUs) transmitted as audio pre-roll data'
                    ),
                ]
            ),
            'UsacConfig' => new Element(
                null,
                [
                    'bsOutputChannelPos' => new Field(
                        'describes loudspeaker positions which are associated to a given channel'
                    ),
                    'channelConfigurationIndex' => new Field(
                        'determines the channel configuration [...] Channel configurations, meaning of channelConfigurationIndex, mapping of channel elements to loudspeaker positions'
                    ),
                    'coreCoderFrameLength' => new Field(
                        'Frame length of core-coder, i.e., number of valid samples output by FD/LPD coredecoder'
                    ),
                    'coreSbrFrameLengthIndex' => new Field(
                        'determines the output frame length of the decoder, the sbrRatio and the sbrRatioIndex respectively, as well as the coreCoderFrameLength (ccfl) and the value of numSlots which is used in Mps212'
                    ),
                    'numOutChannels' => new Field(
                        'determines the number of audio channels for which a specific loudspeaker position shall be associated'
                    ),
                    'usacSamplingFrequency' => new Field(
                        'Output sampling frequency'
                    ),
                    'usacSamplingFrequencyIndex' => new Field(
                        'determines the sampling frequency of the audio signal after decoding'
                    ),
                ]
            ),
            'UsacConfig/UsacDecoderConfig' => new Element(
                'This element contains all further information required by the decoder to interpret the bitstream. In particular the SBR resampling ratio is signalled here and the structure of the bitstream is defined here by explicitly stating the number of elements and their order in the bitstream',
                [
                    'usacElementType' => new Field(
                        'Defines the USAC channel element type of the element'
                    ),
                ]
            ),
            'UsacConfig/UsacDecoderConfig/UsacChannelPairElementConfig' => new Element(
                'contains core coder related configuration data'
            ),
            'UsacConfig/UsacDecoderConfig/UsacExtElementConfig' => new Element(
                'This element configuration can be used for configuring any kind of existing or future extensions to the codec',
                [
                    'usacExtElementConfigLength' => new Field(
                        'Signals the length of the extension configuration in bytes'
                    ),
                    'usacExtElementDefaultLengthPresent' => new Field(
                        'signals whether a usacExtElementDefaultLength is conveyed in the UsacExtElementConfig()'
                    ),
                    'usacExtElementPayloadFrag' => new Field(
                        'indicates whether the payload of this extension element may be fragmented and send as several segments in consecutive USAC frames'
                    ),
                ]
            ),
            'UsacConfig/UsacDecoderConfig/UsacLfeElementConfig' => new Element(
            ),
            'UsacConfig/UsacDecoderConfig/UsacSingleChannelElementConfig' => new Element(
                'contains all information needed for configuring the decoder to decode one single channel'
            ),
            'UsacConfigExtension' => new Element(
                null,
                [
                    'fill_byte' => new Field(
                        'Octet of bits which may be used to pad the bitstream with bits that carry no information'
                    ),
                ]
            ),
            'UsacExtElement' => new Element(
                null,
                [
                    'usacExtElementPresent' => new Field(
                    ),
                    'usacExtElementUseDefaultLength' => new Field(
                        'Indicates whether the length of the extension element corresponds to usacExtElementDefaultLength'
                    ),
                ]
            ),
            'UsacFrame' => new Element(
                'Syntax of UsacFrame()',
                [
                    'usacIndependencyFlag' => new Field(
                        'Meaning of usacIndependencyFlag'
                    ),
                ]
            ),
            'UsacChannelPairElement' => new Element(
                'Syntactic element of the bitstream payload containing data for a pair of channels'
            ),
            'UsacLfeElement' => new Element(
                'Syntactic element that contains a low sampling frequency enhancement channel'
            ),
            'UsacSbrData' => new Element(
            ),
            'UsacSingleChannelElement' => new Element(
                'Syntactic element of the bitstream containing coded data for a single audio channel'
            ),
            'drcInstructions' => new Element(
            ),
            'loudnessInfoSet' => new Element(
            ),
        ]
    ),
    'ISO_IEC_23003-4' => new Spec(
        ':2020',
        'DRC',
        'Information technology — MPEG audio technologies — Part 4: Dynamic range control',
        'true',
        '//www.iso.org/standard/75930.html',
        'This document specifies technology for loudness and dynamic range control. It is applicable to most MPEG audio technologies. It offers flexible solutions to efficiently support the widespread demand for technologies such as loudness normalization and dynamic range compression for various playback scenarios.',
        [
            'drcInstructions' => new Element(
                null,
                [
                    'drcSetEffect' => new Field(
                        'Declares the effect of the DRC'
                    ),
                ]
            ),
            'loudnessInfo' => new Element(
                null,
                [
                    'methodDefinition' => new Field(
                    ),
                    'measurementSystem' => new Field(
                    ),
                ]
            ),
            'loudnessInfoSet' => new Element(
                null,
                [
                    'loudnessInfoCount' => new Field(
                        'Number of loudnessInfo() blocks'
                    ),
                ]
            ),
            'uniDrcConfig' => new Element(
                null,
                [
                    'baseChannelCount' => new Field(
                        'Number of channels in the base layout / original audio input'
                    ),
                    'bsSampleRate' => new Field(
                        'Audio sample rate in [Hz]'
                    ),
                    'downmixInstructionsCount' => new Field(
                        'Number of downmixInstructions() [...] blocks'
                    ),
                    'drcCoefficientsUniDrcCount' => new Field(
                        'Number of drcCoefficients blocks'
                    ),
                    'drcInstructionsUniDrcCount' => new Field(
                        'Number of drcInstructions blocks'
                    ),
                ]
            ),
        ]
    ),
    'SMPTE_ST_377-1' => new Spec(
        ':2019',
        'MXF',
        'Material Exchange Format (MXF) — File Format Specification',
        true,
        '//ieeexplore.ieee.org/document/8984681',
        'This document defines the data structure of the Material Exchange Format (MXF) for the interchange of audio-visual material. It defines the data structure for network transport and may be used on storage media. This document does not define internal storage formats for MXF compliant devices. — The document defines all the components of the MXF file specification including all those in the File Header, File Body and File Footer. It defines the application of Partitions in the file that provide valuable features such as the ability for an MXF file to serve many application requirements and recovery of partially received files. The document also defines key features of the file structure including the Partition Packs, the Structural Metadata, the Primer Pack, the Random Index Pack and Index Tables. — The document does not define either the Essence Container or the Descriptive Metadata. Instead, it defines the requirements for these components to be added as a plug-in to an MXF file.',
        [
            'Generic_Sound_Essence_Descriptor' => new Element(
                null,
                [
                    'Audio_sampling_rate' => new Field(
                        'Sampling rate of the audio Essence'
                    ),
                ]
            ),
        ],
        1
    ),
    'QC.EBU.IO' => new Spec(
        null,
        null,
        'QC.EBU.IO basically is a database of definitions of Quality Control tests for audio-visual material. It also hosts reference and example test material (audio and/or video sequences)',
        false,
        '//qc.ebu.io',
        'The tests are used by media companies to verify content, for example when exchanging material with other parties, or when migrating archives.<br><br>The QC.EBU.IO collection functions as an industry reference and helps ensure different QC tool implementations give comparable results for the same Tests. This is important, as providers and users of audiovisual material may not use the same QC product. It also helps educate media staff on what can go wrong with material/what errors to look for.<br><br>Besides hosting the collection of existing QC Test Definitions, QC.EBU.IO is also used as an authoring tool to create new QC Test definitions. This is a collaborative effort, taking place in the EBU QC Group.',
        [
            'Audio_Coding_Syntax' => new Element(
                'System shall check if the syntax of the coded audio bitstream is compliant with the codec specification',
                null,
                '0006F'
            ),
            'Audio_Sample_Rate' => new Element(
                'System shall check if the sampling rate in the wrapper and the bitstream comply with each other',
                null,
                '0013X'
            ),
        ],
        1
    ),
    'ITU-R_BS.2076' => new Spec(
        "-2",
        "ADM",
        'Audio Definition Model',
        false,
        '//www.itu.int/rec/R-REC-BS.2076',
        'This Recommendation describes the structure of a metadata model that allows the format and content of audio files to be reliably described. This model, called the Audio Definition Model (ADM), specifies how XML metadata can be generated to provide the definitions of tracks in an audio file',
        [
            'audioProgramme' => new Element(
                'An audioProgramme element refers to a set of one or more audioContents that are combined to create a full audio programme',
                [
                    'audioProgrammeID' => new Field(
                        '(Attribute) ID of the programme'
                    ),
                    'audioProgrammeName' => new Field(
                        '(Attribute) Name of the programme'
                    ),
                    'audioProgrammeLanguage' => new Field(
                        '(Attribute) Language of the dialogue content contained in this programme'
                    ),
                    'start' => new Field(
                        '(Attribute) Start time for the programme'
                    ),
                    'end' => new Field(
                        '(Attribute) End time for the programme'
                    ),
                    'typeLabel' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'typeDefinition' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'typeLink' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'typeLanguage' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'formatLabel' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'formatDefinition' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'formatLink' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'formatLanguage' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'maxDuckingDepth' => new Field(
                        '(Attribute) Indicates the maximum amount of automatic ducking allowed for every audioObject in the programme'
                    ),
                    'audioProgrammeLabel' => new Field(
                        'Definition of audioProgramme label'
                    ),
                    'audioContentIDRef' => new Field(
                        'Reference to content'
                    ),
                    'loudnessMetadata' => new Field(
                        'The audio could be corrected or normalized by numerous means, relating to loudness algorithm, regional recommended practice followed, and by what correction type'
                    ),
                    'integratedLoudness' => new Field(
                        '(loudnessMetadata) Integrated loudness value'
                    ),
                    'audioProgrammeReferenceScreen' => new Field(
                        'Specification of a reference/ production/monitoring screen size for the audioProgramme,'
                    ),
                    'authoringInformation' => new Field(
                        ''
                    ),
                    'referenceLayout' => new Field(
                        '(authoringInformation) (Attribute) The reference layout describes the loudspeaker layout for which the content of the audioProgramme was originally produced for'
                    ),
                    'audioPackFormatIDRef' => new Field(
                        '(authoringInformation) Reference to an audioPackFormat used as the reference layout during production'
                    ),
                    'alternativeValueSetIDRef' => new Field(
                        'Reference to an alternativeValueSet within an audioObject'
                    ),
                ]
            ),
            'audioContent' => new Element(
                'An audioContent element describes the content of one component of a programme (e.g. background music), and refers to audioObjects to tie the content to its format. This element includes loudness metadata',
                [
                    'audioContentID' => new Field(
                        '(Attribute) ID of the content'
                    ),
                    'audioContentName' => new Field(
                        '(Attribute) Name of the content'
                    ),
                    'audioContentLanguage' => new Field(
                        '(Attribute) Language of the content'
                    ),
                    'typeLabel' => new Field(
                        '(Attribute) (Only in buggy files)'
                    ),
                    'audioContentLabel' => new Field(
                        'Definition of an audioContent label'
                    ),
                    'audioObjectIDRef' => new Field(
                        'Reference to audioObject'
                    ),
                    'loudnessMetadata' => new Field(
                        'Loudness'
                    ),
                    'dialogue' => new Field(
                        'If the audio is not dialogue set a value of 0; if it contains only dialogue set a value of 1; if it contains both then set a value of 2.'
                    ),
                    'alternativeValueSetIDRef' => new Field(
                        'Reference to an alternativeValueSet within an audioObject'
                    ),
                ]
            ),
            'audioObject' => new Element(
                'An audioObject establishes the relationship between the content, the format via audio packs, and the assets using the track UIDs',
                [
                    'audioObjectID' => new Field(
                        '(Attribute) ID of the object'
                    ),
                    'audioObjectName' => new Field(
                        '(Attribute) Name of the object'
                    ),
                    'start' => new Field(
                        '(Attribute) Start time for the object, relative to the start of the audioProgramme'
                    ),
                    'startTime' => new Field(
                        '(Attribute) (only in legacy files)'
                    ),
                    'duration' => new Field(
                        '(Attribute)  Duration of object'
                    ),
                    'dialogue' => new Field(
                        '(Attribute) If the audio is not dialogue set a value of 0; if it contains only dialogue a value of 1; if it contains both then a value of 2.'
                    ),
                    'importance' => new Field(
                        '(Attribute) Importance of an object'
                    ),
                    'interact' => new Field(
                        '(Attribute) Set to 1 if a user can interact with the object, 0 if not'
                    ),
                    'disableDucking' => new Field(
                        '(Attribute) Set to 1 to disallow automatic ducking of object, 0 to allow ducking'
                    ),
                    'typeLabel' => new Field(
                        '(Attribute) (Only in buggy files)'
                    ),
                    'audioPackFormatIDRef' => new Field(
                        'Reference to an audioPackFormat for format description'
                    ),
                    'audioObjectIDRef' => new Field(
                        'Reference to another audioObject'
                    ),
                    'audioObjectLabel' => new Field(
                        'Definition of audioObject label'
                    ),
                    'audioComplementaryObjectGroupLabel' => new Field(
                        'Definition of a label for a group of complementary audioObjects'
                    ),
                    'audioComplementaryObjectIDRef' => new Field(
                        'Reference to another audioObject that is complementary to the object, e.g. to describe mutually exclusive languages'
                    ),
                    'audioTrackUIDRef' => new Field(
                        'Reference to an audioTrackUID'
                    ),
                    'audioObjectInteraction' => new Field(
                        'Specification of possible user interaction with the object'
                    ),
                    'gain' => new Field(
                        'Definition of a gain value to be applied to all audio samples referenced by the audioObject'
                    ),
                    'headLocked' => new Field(
                        'Indicates if the perceived location of the audio element is locked to the head or not locked'
                    ),
                    'positionOffset' => new Field(
                        'Apply an offset to all elements in the audioObjects'
                    ),
                    'mute' => new Field(
                        'Status of the audioObject to play back or not.'
                    ),
                    'alternativeValueSet' => new Field(
                        'An alternative set of parameters that will be used if the alternativeValueSetID is referenced by an audioProgramme or audioContent element'
                    ),
                ]
            ),
            'audioPackFormat' => new Element(
                'The audioPackFormat groups together one or more audioChannelFormats that belong together',
                [
                    'audioPackFormatID' => new Field(
                        '(Attribute) ID for the pack'
                    ),
                    'audioPackFormatName' => new Field(
                        '(Attribute) Name for the pack'
                    ),
                    'typeLabel' => new Field(
                        '(Attribute) Descriptor of the type of channel'
                    ),
                    'typeDefinition' => new Field(
                        '(Attribute) Description of the type of channel'
                    ),
                    'typeLink' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'typeLanguage' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'importance' => new Field(
                        '(Attribute) Importance of a pack'
                    ),
                    'audioChannelFormatIDRef' => new Field(
                        'Reference to an audioChannelFormat'
                    ),
                    'audioPackFormatIDRef' => new Field(
                        'Reference to an audioPackFormat'
                    ),
                    'absoluteDistance' => new Field(
                        'Absolute distance'
                    ),
                    'encodePackFormatIDRef' => new Field(
                        '(Matrix) Reference to an encoding matrix audioPackFormat from a decoding matrix'
                    ),
                    'decodePackFormatIDRef' => new Field(
                        '(Matrix) Reference to a decoding matrix audioPackFormat from an encoding matrix'
                    ),
                    'inputPackFormatIDRef' => new Field(
                        '(Matrix) Reference to a channel-based (DirectSpeakers) input audioPackFormat'
                    ),
                    'outputPackFormatIDRef' => new Field(
                        '(Matrix) Reference to a channel-based (DirectSpeakers) matrix decoded audioPackFormat'
                    ),
                    'normalization' => new Field(
                        '(HOA) Indicates the normalization scheme of the HOA content (N3D, SN3D, FuMa)'
                    ),
                    'nfcRefDist' => new Field(
                        '(HOA) Indicates the reference distance of the loudspeaker setup for near-field compensation (NFC)'
                    ),
                    'screenRef' => new Field(
                        '(HOA) Indicates whether the content is screen-related or not'
                    ),
                ]
            ),
            'audioChannelFormat' => new Element(
                'An audioChannelFormat represents a single sequence of audio samples on which some action may be performed, such as movement of an object, which is rendered in a scene. It is sub-divided in the time domain into one or more audioBlockFormats',
                [
                    'audioChannelFormatID' => new Field(
                        '(Attribute) ID of the channel'
                    ),
                    'audioChannelFormatName' => new Field(
                        '(Attribute) Name of the channel'
                    ),
                    'typeLabel' => new Field(
                        '(Attribute) Descriptor of the type of channel'
                    ),
                    'typeDefinition' => new Field(
                        '(Attribute) Description of the type of channel'
                    ),
                    'typeLink' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'typeLanguage' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'frequency' => new Field(
                        'frequency'
                    ),
                ]
            ),
            'audioChannelFormat/audioBlockFormat' => new Element(
                'An audioBlockFormat represents a single sequence of audioChannelFormat samples with fixed parameters, including position, within a specified time interval',
                [
                    'audioBlockFormatID' => new Field(
                        '(Attribute) ID for block'
                    ),
                    'rtime' => new Field(
                        '(Attribute) Start time of block'
                    ),
                    'duration' => new Field(
                        '(Attribute) Duration of block'
                    ),
                    'lstart' => new Field(
                        '(Attribute) '
                    ),
                    'lduration' => new Field(
                        '(Attribute) (S-ADM) Duration of block in the S-ADM metadata frame'
                    ),
                    'initializeBlock' => new Field(
                        '(Attribute) (S-ADM) If the initializeBlock is set to ‘1’, it indicates the audioBlockFormat of ‘AB_xxxxyyyy_00000000’ is used to specify initial values of all elements for the first audio block in the frame'
                    ),
                    'gain' => new Field(
                        'Definition of a gain value to be applied to all audio samples corresponding to the audioBlockFormat'
                    ),
                    'importance' => new Field(
                        'Importance of the audioChannelFormat, defined for the duration of the current audioBlockFormat'
                    ),
                    'headLocked' => new Field(
                        'Indicates if the perceived location of the audio element is locked to the head or not locked'
                    ),
                    'headphoneVirtualise' => new Field(
                        'Specifies whether the object should be virtualised using a headphone virtualiser or not'
                    ),
                    'speakerLabel' => new Field(
                        'A reference to the label of the speaker position'
                    ),
                    'position' => new Field(
                        'Exact location of sound'
                    ),
                    'outputChannelFormatIDRef' => new Field(
                        '(Matrix) For defining a decoding or direct matrix, this is the output audioChannelFormat that defines the channel being decoded to'
                    ),
                    'outputChannelIDRef,' => new Field(
                        '(Only in legacy files)'
                    ),
                    'jumpPosition' => new Field(
                        '(Matrix, Objects) If jumpPosition is set to 1 the position will change instantly from the previous block’s position. If set to 0 then interpolation of the position will take the entire length of the block'
                    ),
                    'matrix' => new Field(
                        '(Matrix) Matrix'
                    ),
                    'coefficient' => new Field(
                        '(Matrix) Multiplication factor of another channel'
                    ),
                    'width' => new Field(
                        '(Objects) horizontal extent'
                    ),
                    'depth' => new Field(
                        '(Objects) vertical extent'
                    ),
                    'height' => new Field(
                        '(Objects) distance extent'
                    ),
                    'cartesian' => new Field(
                        'Specifies coordinate system'
                    ),
                    'diffuse' => new Field(
                        'Describes the diffuseness of an audioObject (if it is diffuse or direct sound)'
                    ),
                    'channelLock' => new Field(
                        'If set to 1 a renderer can lock the object to the nearest channel or speaker, rather than normal rendering'
                    ),
                    'objectDivergence' => new Field(
                        'Adjusts the balance between the object’s specified position and two other positions specified by the azimuthRange value'
                    ),
                    'zoneExclusion' => new Field(
                        'Indicates which speaker/room zones the object should not be rendered through'
                    ),
                    'equation' => new Field(
                        '(HOA) An equation to describe the HOA component'
                    ),
                    'order' => new Field(
                        '(HOA) Order of the HOA component'
                    ),
                    'degree' => new Field(
                        '(HOA) Degree of the HOA component'
                    ),
                    'normalization' => new Field(
                        '(HOA) Indicates the normalization scheme of the HOA component (N3D, SN3D, FuMa)'
                    ),
                    'nfcRefDist' => new Field(
                        '(HOA) Indicates the reference distance of the loudspeaker setup for near-field compensation (NFC)'
                    ),
                    'screenRef' => new Field(
                        '(Objects, HOA) Indicates whether the object is screen-related or not'
                    ),
                ]
            ),
            'audioTrackUID' => new Element(
                'The audioTrackUID uniquely identifies a track or asset within a file or recording of an audio scene',
                [
                    'UID' => new Field(
                        '(Attribute) The actual UID value'
                    ),
                    'sampleRate' => new Field(
                        '(Attribute) Sample rate of track'
                    ),
                    'bitDepth' => new Field(
                        '(Attribute) Bit-depth of track'
                    ),
                    'typeLabel' => new Field(
                        '(Attribute) (Only in buggy files)'
                    ),
                    'audioMXFLookUp' => new Field(
                        'MXF sub-elements'
                    ),
                    'audioTrackFormatIDRef' => new Field(
                        'Reference to an audioTrackFormat description'
                    ),
                    'audioChannelFormatIDRef' => new Field(
                        'Reference to an audioChannelFormat description'
                    ),
                    'audioPackFormatIDRef' => new Field(
                        'Reference to an audioPackFormat description'
                    ),
                ]
            ),
            'audioTrackFormat' => new Element(
                'The audioTrackFormat element corresponds to a single set of samples or data in a single track in a storage medium',
                [
                    'audioTrackFormatID' => new Field(
                        '(Attribute) ID for track'
                    ),
                    'audioTrackFormatName' => new Field(
                        '(Attribute) Name for track'
                    ),
                    'typeLabel' => new Field(
                        '(Attribute) (Only in buggy files)'
                    ),
                    'typeDefinition' => new Field(
                        '(Attribute) (Only in buggy files)'
                    ),
                    'formatLabel' => new Field(
                        '(Attribute) Descriptor of the format'
                    ),
                    'formatDefinition' => new Field(
                        '(Attribute) Description of the format'
                    ),
                    'formatLink' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'formatLanguage' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'audioStreamFormatIDRef' => new Field(
                        'Reference to an audioStreamFormat'
                    ),
                ]
            ),
            'audioStreamFormat' => new Element(
                'A stream is a combination of tracks (or one track) required to render a channel, object, HOA component or pack',
                [
                    'audioStreamFormatID' => new Field(
                        '(Attribute) ID for the stream'
                    ),
                    'audioStreamFormatName' => new Field(
                        '(Attribute) Name of the stream'
                    ),
                    'typeLabel' => new Field(
                        '(Attribute) (Only in buggy files)'
                    ),
                    'typeDefinition' => new Field(
                        '(Attribute) (Only in buggy files)'
                    ),
                    'formatLabel' => new Field(
                        '(Attribute) Descriptor of the format'
                    ),
                    'formatDefinition' => new Field(
                        '(Attribute) Description of the format'
                    ),
                    'formatLink' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'formatLanguage' => new Field(
                        '(Attribute) (Unused)'
                    ),
                    'audioChannelFormatIDRef' => new Field(
                        'Reference to audioChannelFormat'
                    ),
                    'audioPackFormatIDRef' => new Field(
                        'Reference to audioPackFormat'
                    ),
                    'audioTrackFormatIDRef' => new Field(
                        'Reference to audioTrackFormat'
                    ),
                ]
            ),
        ],
        1
    ),
    'Dolby_Atmos_Master_ADM_Profile' => new Spec(
        " v1.1",
        null,
        'This documentation specifies requirements, recommendations, and constraints for the Dolby Atmos Master ADM Profile',
        false,
        '//professionalsupport.dolby.com/s/article/Dolby-Atmos-ADM-Profile-specification',
        'This documentation specifies a required subset of ADM to define a Dolby Atmos master ADM profile. The profile is intended to support easier use and implementation of ADM and ensure interoperability among ADM-capable systems ingesting or outputting Dolby Atmos content. Check <a href="./ITU-R_BS.2076">ITU-R BS.2076 (ADM)</a> page for the list of checked elements.',
        [
        ],
        1
    ),
];

/**
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
class Specs
{
    public static function listSpecs()
    {
        global $dbSpecs;
        
        // List
        foreach ($dbSpecs as $specId => $spec) {
            $list[] = '<a href="Specs/' . $specId . '">' . str_replace('_', ' ', $specId) . '</a>' . ($spec->shortName ? (': ' . $spec->shortName) : '');
        }
        $data [] = [ 'List of specifications with at least 1 test supported', [ [ null, $list ] ] ];
        
        return $data;
    }

    public static function listSpecInfo($specId)
    {
        global $dbSpecs;
        
        $spec = $dbSpecs[$specId];
        if (!$spec) {
            return null;
        }

        // Short name
        $data [] = [ 'Short name of the specification', [ [ null, [ str_replace('_', ' ', $specId) . ($spec->shortName ? (' (' . $spec->shortName . ')') : '') ] ] ] ] ;
        
        // Full name
        if ($spec->longName || $spec->latest || $spec->website) {
            $details = '';
            if ($spec->longName) {
                if (!empty($details)) {
                    $details .= '<br>';
                }
                $details .= $spec->longName . '.';
            }
            if ($spec->latest) {
                if (!empty($details)) {
                    $details .= '<br>';
                }
                $details .= 'Latest known version is ' . str_replace('_', ' ', $specId) . $spec->latest . '.';
            }
            if ($spec->website) {
                if (!empty($details)) {
                    $details .= '<br>';
                }
                $details .= 'You can <a href="' . $spec->website . '">' . ($spec->paywall ? 'buy' : 'read') . ' this specification</a>.';
            }
            $data [] = [ 'Full name of the specification', [ [ null, [ $details ] ] ] ] ;
        }
        
        // Abstract
        if ($spec->abstract) {
            $data [] = [ 'Abstract', [ [ null, [ $spec->abstract ] ] ] ] ;
        }
        
        // Elements
        $elementsList = [];
        foreach ($spec->elements as $element => $details) {
            $name = $element;
            if ($spec->flags & 1) {
                $name = str_replace('_', ' ', $element);
            }
            $elementsList[] = '<a href="' . $specId . '/' . $element . '">' . $name . '</a>';
        }
        if (!empty($elementsList)) {
            $data [] = [ 'List of elements with at least one check', [ [ null, $elementsList ] ] ] ;
        }
       
        // Checks
        $checks = (new Checks)->getSpecChecks($specId);
        if (!empty($checks)) {
            $data [] = [ 'List of checks involving this specification', [ [ null, $checks ] ] ];
        }

        return $data;
    }

    public static function listElementInfo($specId, $elementId, $urlPrefix)
    {
        global $dbSpecs;
        
        $spec = $dbSpecs[$specId];
        if (!$spec) {
            return null;
        }
        $element = $spec->elements[$elementId];
        if (!$element) {
            return null;
        }

        // Short name
        $shortName = $elementId;
        if ($spec->flags & 1) {
            $shortName = str_replace('_', ' ', $shortName);
        }
        $data [] = [ 'Name of this element', [ [ null, [ $shortName ] ] ] ] ;

        // Description
        if ($element->description) {
            $data [] = [ 'Description', [ [ null, [ $element->description ] ] ] ] ;
        }

        // Source
        if ($specId =="QC.EBU.IO") {
            $source[] = '<br><a href="' . $spec->website . '/items/' . $element->deepLink . '/">Read more about this card on EBU website...</a>';
        }
        $data [] = [ 'Source', [ [ '<a href="' . $urlPrefix . 'Specs/' . $specId . '">' . str_replace('_', ' ', $specId) . '</a>' . ($spec->shortName ? (' (' . $spec->shortName .')') : ''), $source ] ] ];
       
        // Fields
        foreach ($element->fields as $fieldId => $field) {
            $fieldsList[] = '<a href="' . end(explode('/', $elementId)) . '/' . $fieldId . '">' . $fieldId . '</a>' . ($field ? (': ' . $field->description) : '');
        }
        if (!empty($fieldsList)) {
            $data [] = [ 'List of fields with at least one check', [ [ null, $fieldsList ] ] ] ;
        }

        // Checks
        $checks = (new Checks)->getSpecElementChecks($specId, $elementId, $urlPrefix);
        if (!empty($checks)) {
            $data [] = [ 'List of checks involving this element', [ [ null, $checks ] ] ];
        }
        
        return $data;
    }

    public static function listFieldInfo($specId, $elementId, $fieldId, $urlPrefix)
    {
        global $dbSpecs;
        
        $spec = $dbSpecs[$specId];
        if (!$spec) {
            return null;
        }
        $element = $spec->elements[$elementId];
        if (!$element) {
            // Field does not exist, it may be a element with / in its name, let's try
            return (new Specs)->listElementInfo($specId, $elementId . '/' . $fieldId, $urlPrefix);
        }
        $field = $element->fields[$fieldId];
        if (!$field) {
            // Field does not exist, it may be a element with / in its name, let's try
            return (new Specs)->listElementInfo($specId, $elementId . '/' . $fieldId, $urlPrefix);
        }

        // Short name
        $shortName = $fieldId;
        if ($spec->flags & 1) {
            $shortName = str_replace('_', ' ', $shortName);
        }
        $data [] = [ 'Name of this field', [ [ null, [ $shortName ] ] ] ] ;

        // Description
        if ($field->description) {
            $data [] = [ 'Description', [ [ null, [ $field->description ] ] ] ] ;
        }
       
        // Source
        if ($specId =="QC.EBU.IO") {
            $source[] = '<br><a href="//qc.ebu.io/items/' . $fieldId . '">Read more about this card on EBU website...</a>';
        } else {
            $name = $elementId;
            if ($spec->flags & 1) {
                $name = str_replace('_', ' ', $elementId);
            }
            $source = [ '<a href="' . $urlPrefix . 'Specs/' . $specId . '/' . $elementId . '">' . $name . '</a>' ];
        }
        $data [] = [ 'Source', [ [ '<a href="' . $urlPrefix . 'Specs/' . $specId . '">' . str_replace('_', ' ', $specId) . '</a> (' . $spec->shortName . ')', $source ] ] ];
        
        // Checks
        $checks = (new Checks)->getSpecFieldChecks($specId, $elementId, $fieldId, $urlPrefix);
        if (!empty($checks)) {
            $data [] = [ 'List of checks involving this field', [ [ null, $checks ] ] ];
        }

        return $data;
    }

    public static function getSpecs()
    {
        global $dbSpecs;
        return $dbSpecs;
    }
}
