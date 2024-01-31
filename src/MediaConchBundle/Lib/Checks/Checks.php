<?php

namespace MediaConchBundle\Lib\Checks;

use MediaConchBundle\Lib\Checks\Specs;

class Check
{
    public $description;
    public $severityId;
    public $references;
    public $groups;
    public $qcEbuIos;
    
    public function __construct($description, $severityId = null, $references = null, $groups = null, $qcEbuIos = null)
    {
        $this->description = $description;
        $this->severityId = $severityId;
        $this->references = $references;
        $this->groups = $groups;
        $this->qcEbuIos = $qcEbuIos;
    }
}

class Reference
{
    public $specId;
    public $elementId;
    public $fieldId;
    public $reason;
    public $action;
    
    public function __construct($specId = null, $elementId = null, $fieldId = null, $reason = null, $action = null)
    {
        $this->specId = $specId;
        $this->elementId = $elementId;
        $this->fieldId = $fieldId;
        $this->reason = $reason;
        $this->action = $action;
    }
}

$GLOBALS['dbChecks'] =
[
    null,
    new Check(
        '<code>(content element)</code> is <code>(content element value for independent)</code> but <code>(container element for IPF)</code> or <code>(container element for IF)</code> does not indicate this frame is independent.',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/stss',
                'sample_number',
                'Fix the muxer in order to correctly fill <code>stss</code> (if non fragmented MP4 file and USAC <code>AudioPreRoll</code> is present) or <code>trun</code> (if fragmented MP4 file and USAC <code>AudioPreRoll</code> is present) or MP4 <code>sbgp</code> (if <code>AudioPreRoll</code> is not present) with this frame number, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/sbgp'
            ),
            new Reference(
                'ISO_IEC_14496-12',
                'moov/traf/sbgp'
            ),
            new Reference(
                'ISO_IEC_14496-12',
                'moof/traf/trun'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacFrame',
                'usacIndependencyFlag'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>usacIndependencyFlag</code> is <code>0</code> for first <code>UsacFrame</code> inside <code>AudioPreRoll</code>',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacFrame',
                'usacIndependencyFlag',
                '"The pre-roll frames with index “0” shall be independently decodable, i.e., usacIndependencyFlag shall be set to “1”."',
                'Fix the USAC encoder in order to correctly fill the first <code>AudioPreRoll</code> frame of this frame with a frame having <code>usacIndependencyFlag</code> set to 1, then re-encode the content.'
            ),
        ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element)</code> <code>(container value)</code> does not match <code>(content format)</code> <code>(content element)</code> <code>(content value)</code>',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'AudioSampleEntry',
                'samplerate',
                null,
                'Fix the muxer in order to correctly fill <code>samplerate</code> with the right sampling rate, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_14496-3',
                'AudioSpecificConfig',
                'samplingFrequency',
                null,
                'Fix the muxer in order to correctly fill <code>samplingFrequency</code> (and/or <code>extensionSamplingFrequency</code> in case of AAC SBR) with the right sampling rate, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_14496-3',
                'AudioSpecificConfig',
                'extensionSamplingFrequency'
            ),
            new Reference(
                'SMPTE_ST_377-1',
                'Generic_Sound_Essence_Descriptor',
                'Audio_sampling_rate',
                null,
                'Fix the muxer in order to correctly fill <code>Audio sampling rate</code> with the right sampling rate, then remux the content.'
            ),
            new Reference(
                'ETSI_TS_102_114',
                'CoreFrameHeader',
                'SFREQ'
            ),
            new Reference(
                'ETSI_TS_102_366',
                'syncframe/syncinfo',
                'fscod'
            ),
            new Reference(
                'ETSI_TS_102_366',
                'syncframe/bsi',
                'fscod'
            ),
            new Reference(
                'ETSI_TS_102_366',
                'AC3SpecificBox',
                'fscod'
            ),
            new Reference(
                'ETSI_TS_102_366',
                'EC3SpecificBox',
                'fscod'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'usacSamplingFrequency'
            ),
            new Reference(
                'ISO_IEC_23003-4',
                'uniDrcConfig',
                'bsSampleRate',
                null,
                'Fix the encoder in order to correctly fill <code>bsSampleRate</code> with the right sampling rate, then reencode the content.'
            ),
        ],
        [ 'Crosscheck', ],
        [ 'Audio_Sample_Rate', ]
    ),
    new Check(
        '<code>usacIndependencyFlag</code> is <code>1</code> but <code>MP4</code> <code>stts</code> or <code>(container format)</code> <code>(container element for independent frame (IF))</code> does not indicate this frame is independent',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/stss',
                'sample_number'
            ),
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/sbgp',
                'group_description_index'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacFrame',
                'usacIndependencyFlag'
            ),
        ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element)</code> <code>(container field)</code> <code>(container value)</code> does not match <code>(content format)</code> <code>(content element)</code> <code>(content field)</code> <code>(content value)</code>',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/stts',
                'sample_count',
                null,
                'Fix the muxer in order to correctly fill <code>sample_count</code> with the right sample count, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'coreCoderFrameLength'
            ),
        ],
        [ 'Crosscheck', ]
    ),
    new Check(
        '<code>AudioPreRoll</code> is not present so this frame is an independent frame (IF) but <code>(container format)</code> <code>(container element for independent frame (IF))</code> does not indicate this frame as such',
        'Error'
    ),
    new Check(
        '<code>auLen</code> is <code>0</code> but preroll frame shall not be empty',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'AudioPreRoll',
                'auLen',
                'Common sense, <code>auLen</code> is <code>AccessUnit</code> length, and <code>AccessUnit</code> uses <code>UsacFrame</code> which can not be empty',
                'Fix the encoder in order to correctly fill <code>auLen</code> in the <code>AudioPreRoll</code> element, then reencode the content.'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>configLen</code> is <code>0</code> but it is recommended to have a preroll config',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'AudioPreRoll',
                'configLen',
                '<code>configLen</code> is preroll frames related <code>Config</code> element length, and out of band <code>UsacConfig</code> may be not the same as the one for preroll frames, it is recommended to have the preroll configuration beside the preroll frames.',
                'Configure or update the USAC encoder in order to put a <code>Config</code> element in the <code>AudioPreRoll</code> element, then reencode the content.'
            ),
        ],
        [ 'General_compliance', 'Best_practice' ]
    ),
    new Check(
        'Bitstream parsing ran out of data to read before the end of the syntax was reached, most probably the bitstream is malformed',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'AudioPreRoll',
                null,
                'Fix the encoder in order to correctly fill the impacted element, then reencode the content.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacFrame'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        'Extra bytes after the end of the syntax was reached',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'AudioPreRoll',
                null,
                'Fix the muxer in order to correctly fill the impacted element, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacFrame'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        'Extra zero bytes after the end of the syntax was reached',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'AudioPreRoll',
                null,
                'Fix the muxer in order to correctly fill the impacted element, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacFrame'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>AudioPreRoll</code> <code>usacExtElementPresent</code> is <code>1</code> for <code>AudioPreRoll</code> inside <code>AudioPreRoll</code>',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacExtElement',
                'usacExtElementPresent',
                '"The pre-roll frames with index “0” shall be independently decodable, i.e., usacIndependencyFlag shall be set to “1”."',
                'Fix the encoder in order to avoid <code>usacExtElementPresent</code> value of <code>1</code> when inside <code>AudioPreRoll</code>, then reencode the content.'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>(preroll count field)</code> is <code>(value)</code> but <code>(expected value)</code> is recommended due to <code>(reason)</code>',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'AudioPreRoll',
                'numPreRollFrames',
                'Recommendation in order to be sure that the current frame, which is an independent frame, can provide valid decoded content. Else it may lead to an audio content gap during a content switch.',
                'Configure or update the USAC encoder in order to put the following count of pre-roll frames:<br>- 1 if no SBR<br>- 2 if SBR without harmonic patching<br>- 3 if SBR with harmonic patching<br>then reencode the content'
            ),
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/sbgp',
                'roll_distance',
                'Recommendation in order to be sure that the current frame, which is an independent frame, can provide valid decoded content. Else it may lead to an audio content gap during a content switch.',
                'If the stream format encoder is correctly set (see above), it may be a muxer error, check that the muxer correctly fills <code>sbgp</code> with the right <code>roll_distance</code>, then remux the content.'
            ),
        ],
        [ 'General_compliance', 'Best_practice' ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element for immediate play-out frame (IPF))</code> or <code>(container format)</code> <code>(container element for independent frame (IF))</code> does not indicate this frame is independent but <code>(content format)</code> <code>(content element)</code> <code>(content field)</code> <code>(value)</code> indicates this frame is independent',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/stss',
                'sample_number',
                null,
                'Fix the muxer in order to correctly fill <code>stss</code> with this frame number or <code>sbgp</code> with <code>group_description_index</code> value not <code>0</code> for this frame number, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/sbgp',
                'group_description_index'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacFrame',
                'usacIndependencyFlag'
            ),
        ],
        [ 'Crosscheck', ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element for immediate play-out frame (IPF))</code> indicates this frame is an immediate play-out frame (IPF) but <code>(content format)</code> <code>(content element)</code> <code>(content field)</code> <code>(value)</code> indicates this frame is not an immediate play-out frame (IPF)',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/stss',
                'sample_number',
                null,
                'Fix the muxer in order to correctly fill <code>stss</code> without this frame number, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacFrame',
                'usacIndependencyFlag'
            ),
        ],
        [ 'Crosscheck', ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element for independent frame (IF))</code> indicates this frame is an independent frame (IF) but <code>(content format)</code> <code>(content element)</code> <code>(content field)</code> <code>(value )</code> indicates this frame is not an independent frame (IF)',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/sbgp',
                'group_description_index',
                null,
                'Fix the muxer in order to correctly fill <code>sbgp</code> with <code>group_description_index</code> not <code>0</code> for this frame number, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_14496-12',
                'moof/traf/sbgp',
                'group_description_index'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacFrame',
                'usacIndependencyFlag'
            ),
        ],
        [ 'Crosscheck', ]
    ),
    new Check(
        'This is the first frame in this stream but <code>USAC</code> <code>UsacFrame</code> <code>usacIndependencyFlag</code> is <code>0</code> so this frame is not decodable',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacFrame',
                'usacIndependencyFlag',
                null,
                'Fix the muxer in order to put an independent USAC frame at the begining of the stream or discard frames before the first independent USAC frame, then reencode the content.'
            ),
        ],
        [ 'Crosscheck', ]
    ),
    new Check(
        'This is the first frame in this stream but <code>USAC</code> <code>AudioPreRoll</code> is not present',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'AudioPreRoll',
                null,
                'Not explicitly forbidden but in practice the first frames can not provide any valid decoded content due to the lack of previous frames which are needed for a valid decoded content for this frame',
                'Configure or update the USAC encoder in order to put the following count of pre-roll frames:<br>- 1 if no SBR<br>- 2 if SBR without harmonic patching<br>- 3 if SBR with harmonic patching<br>at least for the first frame then reencode the content'
            ),
        ],
        [ 'General_compliance', 'Best_practice' ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element for immediate play-out frame (IPF))</code> does not indicate this frame is an immediate play-out frame (IPF) but <code>USAC</code> <code>AudioPreRoll</code> is present',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/stss',
                'sample_number',
                null,
                'Fix the muxer in order to correctly fill <code>stss</code> (if non fragmented MP4 file) or <code>trun</code> (if fragmented MP4 file) with this frame number, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'AudioPreRoll',
                null,
                '"Frames that use AudioPreRoll() [...] are considered to be immediate play-out frames (IPF) and shall be signalled as sync samples"'
            ),
        ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element for independent frame (IF))</code> indicates this frame is an independent frame (IF) but <code>USAC</code> <code>AudioPreRoll</code> is present',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/sbgp',
                'group_description_index',
                null,
                'Fix the muxer in order to correctly fill <code>sbgp</code> with this frame number, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'AudioPreRoll',
                null,
                '"If independently decodable frames (IF) [...] are to be signalled, they shall be signalled by means of the <code>AudioPreRollEntry</code>"'
            ),
        ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element for immediate play-out frame (IPF))</code> indicates this frame is an immediate play-out frame (IPF) but <code>USAC</code> <code>AudioPreRoll</code> is not present',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/stss',
                'sample_number',
                null,
                'Fix the muxer in order to correctly fill <code>stss</code> (if non fragmented MP4 file) or <code>trun</code> (if fragmented MP4 file) without this frame number, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'AudioPreRoll',
                null,
                '"Frames that use AudioPreRoll() [...] are considered to be immediate play-out frames (IPF) and shall be signalled as sync samples"'
            ),
        ],
        [ 'Crosscheck', ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element for independent frame (IF))</code> does not indicate this frame is an independent frame (IF) but <code>USAC</code> <code>AudioPreRoll</code> is not present',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/sbgp',
                'group_description_index',
                null,
                'Fix the muxer in order to correctly fill <code>sbgp</code> without this frame number, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'AudioPreRoll',
                null,
                '"If independently decodable frames (IF) [...] are to be signalled, they shall be signalled by means of the <code>AudioPreRollEntry</code>"'
            ),
        ],
        [ 'Crosscheck', ]
    ),
    new Check(
        '<code>AudioPreRoll</code> <code>usacExtElementConfigLength</code> is <code>1</code> but only <code>0</code> is allowed',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig/UsacDecoderConfig/UsacExtElementConfig',
                'usacExtElementConfigLength',
                '"In order to use AudioPreRoll() for both random access and bitrate adaptation the following restrictions apply: [...] Setup of UsacExtElementConfig() for AudioPreRoll() [...] usacExtElementConfigLength [...] 0"',
                'Fix the encoder in order to set <code>usacExtElementConfigLength</code> value to <code>0</code> when used for <code>AudioPreRoll</code>, then reencode the content.'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>AudioPreRoll</code> <code>usacExtElementDefaultLengthPresent</code> is <code>1</code> but only <code>0</code> is allowed',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig/UsacDecoderConfig/UsacExtElementConfig',
                'usacExtElementDefaultLengthPresent',
                '"In order to use AudioPreRoll() for both random access and bitrate adaptation the following restrictions apply: [...] Setup of UsacExtElementConfig() for AudioPreRoll() [...] usacExtElementDefaultLengthPresent [...] 0"',
                'Fix the encoder in order to set <code>usacExtElementDefaultLengthPresent</code> value to <code>0</code> when used for <code>AudioPreRoll</code>, then reencode the content.'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>AudioPreRoll</code> <code>usacExtElementPayloadFrag</code> is <code>1</code> but only <code>0</code> is allowed',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig/UsacDecoderConfig/UsacExtElementConfig',
                'usacExtElementPayloadFrag',
                '"In order to use AudioPreRoll() for both random access and bitrate adaptation the following restrictions apply: [...] Setup of UsacExtElementConfig() for AudioPreRoll() [...] usacExtElementPayloadFrag [...] 0"',
                'Fix the encoder in order to set <code>usacExtElementPayloadFrag</code> value to <code>0</code> when used for <code>AudioPreRoll</code>, then reencode the content.'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>AudioPreRoll</code> is present in position <code>(value)</code> but only presence in position <code>0</code> is allowed',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig/UsacDecoderConfig/UsacExtElementConfig',
                null,
                '"In order to use AudioPreRoll() for both random access and bitrate adaptation the following restrictions apply: [...] The first element of every frame shall be an extension element (UsacExtElement) of type ID_EXT_ELE_AUDIOPREROLL"',
                'Fix the encoder in order to put <code>AudioPreRoll</code> element first, then reencode the content.'
            ),
        ],
        [ 'General_compliance' ],
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>AudioPreRoll</code> <code>usacExtElementUseDefaultLength</code> is <code>1</code> but only <code>0</code> is allowed',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacFrame/UsacExtElement',
                'usacExtElementUseDefaultLength',
                '"if pre-roll data is present, this UsacFrame() shall start with the following bit sequence: [...] “0”: usacExtElementUseDefaultLength"',
                'Fix the encoder in order to set <code>usacExtElementUseDefaultLength</code> value to <code>0</code> when used for <code>AudioPreRoll</code>, then reencode the content.'
            ),
        ]
    ),
    new Check(
        '<code>numPreRollFrames</code> is <code>(numPreRollFrames value)</code> but <code>&lt;= 3</code> is required',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'AudioPreRoll',
                'numPreRollFrames',
                '"numPreRollFrames [...] Shall not be larger than 3"',
                'Fix the encoder in order to set <code>numPreRollFrames</code> value to <code>&lt;= 3</code>, then reencode the content.'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>roll_distance</code> is <code>(roll_distance value)</code> but <code>&gt; 0</code> is required',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/sbgp',
                'roll_distance',
                '"roll_distance [...] A negative value indicates the number of samples before the sample that is a group member that must be decoded in order for recovery to be complete at the marked sample [...] The value zero must not be used" in older specs but negative values were actually never usable in practice and are deprecated in ISO/IEC 14496-12:2022 "The roll_distance shall be a positive value [...] The value zero must not be used"',
                'Fix the muxer in order to correctly fill <code>sbgp</code> with a positive <code>roll_distance</code> value, then remux the content.'
            ),
        ]
    ),
    new Check(
        '<code>roll_distance</code> is <code>(roll_distance value)</code> but <code>&lt;= 3</code> is required',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/sbgp',
                'roll_distance',
                '"roll_distance is a signed integer that gives the number of samples that must be decoded in order for a sample to be decoded correctly. A positive value indicates the number of samples after the sample that is a group member that must be decoded such that at the last of these recovery is complete, i.e. the last sample is correct" and the value must comply to stream format constraints',
                'Fix the muxer in order to correctly fill <code>sbgp</code> with the right <code>roll_distance</code> value, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'AudioPreRoll',
                'numPreRollFrames',
                'Common sense, "numPreRollFrames [...] Shall not be larger than 3" implies a similar limit for preroll without AudioPreRoll'
            ),
        ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element)</code> <code>(container field)</code> <code>(container value)</code> does not permit <code>(content format)</code> <code>(content element)</code> <code>(container value)</code> <code>(content value)</code>',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-1',
                'InitialObjectDescriptor',
                'audioProfileLevelIndication',
                null,
                'Fix the muxer in order to correctly fill <code>InitialObjectDescriptor</code> with the right <code>audioProfileLevelIndication</code> value, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_14496-3',
                'AudioSpecificConfig',
                'audioObjectType'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'channelConfigurationIndex'
            ),
        ],
        [ 'Crosscheck', ]
    ),
    new Check(
        '<code>channelConfigurationIndex</code> <code>(value)</code> implies element order <code>(expected channel config order)</code>',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'channelConfigurationIndex',
                null,
                'Fix the encoder in order to set <code>channelConfigurationIndex </code> value to the value corresponding to the channel type order, then reencode the content.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig/UsacDecoderConfig',
                'usacElementType'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element)</code> <code>(container field)</code> <code>(container value)</code> does not match <code>(content format)</code> <code>(content element)</code> <code>(container value)</code> <code>(content value)</code>',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-3',
                'AudioSpecificConfig',
                'channelConfigurationIndex',
                null,
                'Fix the muxer in order to correctly fill <code>channelConfigurationIndex</code> (and/or <code>extensionChannelConfiguration</code> in case of AAC PS) with the right value, then remux the content.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'channelConfigurationIndex'
            ),
        ],
        [ 'Crosscheck', ]
    ),
    new Check(
        '<code>(field)</code> <code>(value)</code> is known as reserved in <code>(specificiation)</code>, bitstream parsing is partial and may be wrong',
        'Info',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'channelConfigurationIndex',
                null,
                'If ISO/IEC 23003-3:2020 compatibility is expected, configure the encoder to use a value not listed as reserved in ISO/IEC 23003-3:2020, else contact the conformance checker developer in order to get an updated version.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'usacSamplingFrequencyIndex'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'coreSbrFrameLengthIndex'
            ),
        ],
        [ 'Update_needed', ]
    ),
    new Check(
        '<code>usacSamplingFrequency</code> is used but <code>usacSamplingFrequencyIndex</code> <code>(value)</code> could be used instead',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'usacSamplingFrequencyIndex',
                'Not forbidden but there is no good reason to avoid <code>usacSamplingFrequencyIndex</code> when it is possible',
                'Fix the encoder in order to use <code>usacSamplingFrequencyIndex</code> when it is possible, then reencode the content.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'usacSamplingFrequency'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'coreSbrFrameLengthIndex'
            ),
        ],
        [ 'Best_practice', ]
    ),
    new Check(
        '<code>channelConfigurationIndex</code> <code>(value)</code> is used but the <code>usacElementType</code> sequence contains <code>(channel config order)</code>, which is the configuration indicated by <code>channelConfigurationIndex</code> <code>(expected value)</code>',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'channelConfigurationIndex',
                null,
                'If ISO/IEC 23003-3:2020 compatibility is expected, configure the encoder to use a value not listed as reserved in ISO/IEC 23003-3:2020, else contact the conformance checker developer in order to get an updated version.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'UsacDecoderConfig/usacElementType'
            ),
        ],
        [ 'General_compliance', 'Best_practice' ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element)</code> <code>(container value)</code> does not match <code>(content format)</code> <code>(content element)</code> <code>(content value)</code>',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'numOutChannels',
                null,
                'Fix the encoder in order to set <code>baseChannelCount</code> value to <code>numOutChannels</code> value, then reencode the content.'
            ),
            new Reference(
                'ISO_IEC_23003-4',
                'uniDrcConfig',
                'baseChannelCount'
            ),
        ],
        [ 'Crosscheck', ]
    ),
    new Check(
        '<code>Default loudness</code> is present <code>(value)</code> times but only <code>1</code> instance is recommended',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'loudnessInfo',
                null,
                'Not explicitly forbidden but recommended practice to ensure consistent behavior across different implementations',
                'Configure or update the encoder in order to set only 1 instance of <code>Default loudness</code>, then reencode the content.'
            ),
            new Reference(
                'ISO_IEC_23003-4',
                'loudnessInfo'
            ),
        ],
        [ 'General_compliance', 'Best_practice' ]
    ),
    new Check(
        '<code>loudnessInfoSet</code> contains a mix of v0 and v1 <code>loudnessInfo</code>',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'loudnessInfoSet',
                null,
                'Not explicitly forbidden but recommended practice to ensure consistent behavior across different implementations',
                'Configure or update the encoder in order to set only v1 instances of <code>loudnessInfo</code>, then reencode the content.'
            ),
            new Reference(
                'ISO_IEC_23003-4',
                'loudnessInfoSet'
            ),
        ],
        [ 'General_compliance', 'Best_practice' ],
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>loudnessInfoCount</code> is <code>0</code>',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'loudnessInfoSet',
                'loudnessInfoCount',
                'Common sense, no need of loudnessInfoSet if there is no loudnessInfo and it is considered as if missing',
                'Configure or update the encoder in order to set at least 1 instance of <code>loudnessInfo</code>, then reencode the content.'
            ),
            new Reference(
                'ISO_IEC_23003-4',
                'loudnessInfoSet'
            ),
        ],
        [ 'General_compliance', 'Best_practice' ],
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>loudnessInfoSet</code> is missing',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'loudnessInfoSet',
                null,
                '"Specification of metadata sets [...] Required metadata [...] Program loudness or Anchor loudness"',
                'Configure or update the encoder in order to set at least 1 instance of <code>loudnessInfo</code>, then reencode the content.'
            ),
            new Reference(
                'ISO_IEC_23003-4',
                'loudnessInfoSet'
            ),
        ],
        [ 'General_compliance', 'Best_practice' ],
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>(effect)</code> isn\'t in at least one DRC',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-4',
                'drcInstructions',
                'drcSetEffect',
                '"Specification of metadata sets [...] Required metadata [...] Instructions for one or more DRCs where each DRC has a drcSetEffect field in which the following bits can be set to the value 1 with the restriction that each bit shall be set to the value 1 in at least one of the DRCs: (1-based) Bit position 1 (“Late night” effect), Bit position 2 (“Noisy environment” effect), Bit position 3 (“Limited Playback Range” effect), Bit position 6 (“General compression” effect)"',
                'Fix the encoder in order to set at least 1 instance of <code>(effect)</code> in <code>drcInstructions</code>, then reencode the content.'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    null,
    new Check(
        '<code>(element)</code> is present <code>(value)</code> times but only 1 instance is recommended',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacExtElementConfig',
                null,
                'Not explicitly forbidden but recommended practice to ensure consistent behavior across different implementations',
                'Configure or update the encoder in order to set only 1 instance of <code>(element)</code>, then reencode the content.'
            ),
        ],
        [ 'General_compliance', 'Best_practice' ]
    ),
    new Check(
        'Issue detected while computing <code>(element with issue)</code>',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacSbrData',
                null,
                'The parsing of the content led to an incoherent state of the decoder',
                'Configure or update the encoder in order to have a coherent <code>(element with issue)</code> (or content before it), then reencode the content.'
            ),
            new Reference(
                'ISO_IEC_23003-3',
                'arithData',
                null,
                'The parsing of the content led to an incoherent state of the decoder'
            ),
        ]
    ),
    new Check(
        '<code>(methodDefinition-measurementSystem)</code> is present <code>(value)</code> times but only 1 instance is recommended',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-4',
                'loudnessInfo',
                'methodDefinition',
                'Not explicitly forbidden but recommended practice to ensure consistent behavior across different implementations',
                'Configure or update the encoder in order to set only 1 instance of <code>methodDefinition</code>-<code>measurementSystem</code>, then reencode the content.'
            ),
            new Reference(
                'ISO_IEC_23003-4',
                'loudnessInfo',
                'measurementSystem'
            ),
        ],
        [ 'General_compliance', 'Best_practice' ]
    ),
    new Check(
        '<code>(field)</code> <code>(value)</code> is known as reserved in <code>(specificiation)</code>',
        'Info',
        [
            new Reference(
                'ISO_IEC_23003-4',
                'loudnessInfo',
                'measurementSystem',
                '"Coding of measurementSystem field in loudnessInfo() [...] reserved, not permitted [...] Reserved Measurement System"',
                'If ISO/IEC 23003-3:2020 compatibility is expected, configure the encoder to use a value not listed as reserved in ISO/IEC 23003-3:2020, else contact the conformance checker developer in order to get an updated version.'
            ),
        ],
        [ 'Update_needed', ]
    ),
    new Check(
        'None of program loudness or anchor loudness is present in default loudnessInfo',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-4',
                'loudnessInfoSet',
                '"Specification of metadata sets [...] Required metadata [...] Program loudness or Anchor loudness"',
                null,
                'Configure or update the encoder in order to set one of program loudness or anchor loudness, then reencode the content.'
            ),
        ],
        [ 'Update_needed', ]
    ),
    new Check(
        'Version <code>(value)</code> shall not be used',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-4',
                'uniDrcConfig',
                'downmixInstructionsCount',
                '"Supported in-stream payload processing for each profile [...] downmixInstructions [...]" (no x)',
                'Configure or update the encoder in order to use a version not <code>(value)</code>, then reencode the content.'
            ),
            new Reference(
                'ISO_IEC_23003-4',
                'uniDrcConfig',
                'drcCoefficientsUniDrcCount',
                '"Supported in-stream payload processing for each profile [...] drcCoefficientsUniDrc [...]" (no x)'
            ),
            new Reference(
                'ISO_IEC_23003-4',
                'uniDrcConfig',
                'drcInstructionsUniDrcCount',
                '"Supported in-stream payload processing for each profile [...] drcInstructionsUniDrc [...]" (no x)'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>numOutChannels</code> is <code>(value)</code> but the <code>usacElementType</code> sequence contains <code>(value)</code> channels',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'numOutChannels',
                '"numOutChannels shall be equal to or smaller than the accumulated sum of all channels contained in the bitstream"',
                'Fix the encoder to fill <code>numOutChannels</code> with the correct count of channels computed from the <code>usacElementType</code> sequence, then reencode the content.'
            ),
        ],
        [ 'General_compliance' ],
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>numOutChannels</code> is <code>(value)</code>, it is not recommended that the <code>usacElementType</code> sequence contains <code>(value)</code> channels',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'numOutChannels',
                'Not forbidden but it may leads to playback issues with some players due to uncommon value for this <code>usacElementType</code> sequence',
                'Fix the encoder to fill <code>numOutChannels</code> with the correct count of channels computed from the <code>usacElementType</code> sequence, then reencode the content.'
            ),
        ],
        [ 'General_compliance', 'Best_practice' ],
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>numOutChannels</code> is <code>(value)</code>, it is not recommended that the <code>usacElementType</code> sequence contains <code>(value)</code> channels, especially when only one channel of a CPE is included in numOutChannels',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'numOutChannels',
                'Not forbidden but it may leads to playback issues with some players due to uncommon value for this <code>usacElementType</code> sequence, especially when the last element is a CPE so only one of the channels of this CPE must be taken',
                'Fix the encoder to fill <code>numOutChannels</code> with the correct count of channels computed from the <code>usacElementType</code> sequence of use a SCE for the last element rather that a CPE, then reencode the content.'
            ),
        ],
        [ 'General_compliance', 'Best_practice' ],
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element)</code> <code>(container field)</code> <code>(container value)</code> does not permit that the <code>usacElementType</code> sequence starts with <code>SCE CPE</code>',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-1',
                'InitialObjectDescriptor',
                'audioProfileLevelIndication',
                'SCE CPE with xHE-AAC profile is not explicitly forbidden but common sense, due to computing power needed for decoding the third channel with a profile limited to 2 channels, it will likely lead to playback issues with a lot of players',
                'Fix the encoder to avoid a <code>CPE</code> for the second and third channels, then reencode the content.'
            ),
        ],
        [ 'Best_practice' ]
    ),
    new Check(
        '<code>UsacLfeElement</code> support not implemented',
        'Info',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacLfeElement'
            ),
        ],
        [ 'Update_needed' ],
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>(field)</code> is <code>(actual value)</code> but only <code>(expected value)</code> is expected',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfigExtension',
                'fill_byte',
                '"The exact bit pattern used for fill_byte should be \'10100101\'"',
                'Fix the encoder to fill <code>fill_byte</code> with \'10100101\', then reencode the content.'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element)</code> <code>(container field)</code> <code>(container value)</code> implies a channel layout of <code>L R</code>, a channel layout of <code>(channel layout)</code> is not recommended',
        'Warning',
        [
            new Reference(
                'ISO_IEC_14496-1',
                'InitialObjectDescriptor',
                'audioProfileLevelIndication',
                'xHE-AAC profile is intended for stereo content, a channel layout not of <code>L R</code> is unusual and content may be outputted as <code>L R</code> or not outputted at all',
                'Configure or update the USAC encoder in order to put a channel layout of <code>L R</code>, then reencode the content.'
            ),
        ],
        [ 'Best_practice' ]
    ),
    new Check(
        '<code>channelConfigurationIndex</code> is <code>0</code> but <code>channelConfigurationIndex</code> <code>(value)</code> could be used for channel mapping <code>(channel mapping)</code>',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'channelConfigurationIndex',
                'Not forbidden but it may leads to playback issues with some players due to uncommon <code>channelConfigurationIndex</code> value',
                'Configure or update the USAC encoder in order to put a <code>channelConfigurationIndex</code> of <code>(value)</code>, then reencode the content.'
            ),
        ],
        [ 'Best_practice' ]
    ),
    new Check(
        '<code>(field)</code> <code>(value)</code> is present <code>(value)</code> times but only 1 instance is permitted',
        'Error',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'UsacConfig',
                'bsOutputChannelPos',
                '"All entries in the array bsOutputChannelPos shall be mutually distinct"',
                'Fix the encoder to correctly fill <code>bsOutputChannelPos</code>, then reencode the content.'
            ),
        ],
        null,
        [ 'Audio_Coding_Syntax', ]
    ),
    new Check(
        '<code>(field)</code> <code>(value)</code> is already used by another <code>(item)</code>',
        'Error',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/tkhd',
                'track_ID',
                '"Track IDs are never re‐used and cannot be zero."',
                'Fix the encoder to correctly fill <code>track_ID</code>, then remux the content.'
            ),
        ]
    ),
    new Check(
        '<code>(container format)</code> <code>(container element)</code> is not present and this is an independent frame (IF), seeking is not optimal',
        'Info',
        [
            new Reference(
                'ISO_IEC_14496-12',
                'moov/trak/mdia/minf/stbl/sbgp',
                'roll_distance',
                'stts is used for signaling only immediate play-out frames (IPF), but seeking may also be done on independent frames (IF) via sample group mechanics, this would improve seeking behavior through the presence of more seeking points when the player supports sample group mechanics"',
                'Update the muxer to put sbgp and sgpd atoms with a grouping_type of prol, then remux the content.'
            ),
        ],
        [ 'General_compliance', 'Best_practice' ]
    ),
    new Check(
        '<code>(attribute name)</code> attribute is not part of specs',
        'Warning',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat'
            ),
        ],
        [ 'General_compliance' ]
    ),
    new Check(
        '<code>(element name)</code> element is not part of specs',
        'Warning',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioProgramme'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioContent'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioObject'
            ),
            new Reference(
                'ITU-R_BS.2076',
                ''
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackUID'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackFormat'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioStreamFormat'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat/audioBlockFormat'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat/audioBlockFormat/position'
            ),
        ],
        [ 'General_compliance' ]
    ),
    new Check(
        '<code>(attribute name)</code> attribute is not present<code> (extra spec name if needed)</code>',
        'Error',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioProgramme',
                'audioProgrammeID',
                '"audioProgramme attributes [...] audioProgrammeID [...] Required [...] Yes"',
                'Update the encoder to write this element, then reencode the content.'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioProgramme',
                'audioProgrammeName',
                '"audioProgramme attributes [...] audioProgrammeName [...] Required [...] Yes"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'start',
                '"audioProgramme attributes [...] start [...] Required [...] Yes"',
                'Update the encoder to write this element, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'end',
                '"audioProgramme attributes [...] end [...] Required [...] Yes"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'maxDuckingDepth',
                '"audioProgramme attributes [...] maxDuckingDepth [...] This attribute shall not be present"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioContent',
                'audioContentID',
                '"audioContent attributes [...] audioContentID [...] Required [...] Yes"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioContent',
                'audioContentName',
                '"audioContent attributes [...] audioContentName [...] Required [...] Yes"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioObject',
                'audioObjectID',
                '"audioObject attributes [...] audioObjectID [...] Required [...] Yes"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioObject',
                'audioObjectName',
                '"audioObject attributes [...] audioObjectName [...] Required [...] Yes"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'duration',
                '"audioObject attributes [...] duration [...] Required [...] Yes"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                'audioPackFormatID',
                '"audioPackFormat attributes [...] audioPackFormatID [...] Required [...] Yes"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                'audioPackFormatName',
                '"audioPackFormat attributes [...] audioPackFormatName [...] Required [...] Yes"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'typeDefinition',
                '"audioPackFormat attributes [...] typeDefinition [...] Required [...] Yes"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'typeLabel',
                '"audioPackFormat attributes [...] typeLabel [...] Required [...] Yes"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat',
                'audioChannelFormatID',
                '"audioChannelFormat attributes [...] audioChannelFormatID [...] Required [...] Yes"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat',
                'audioChannelFormatName',
                '"audioChannelFormat attributes [...] audioChannelFormatName [...] Required [...] Yes"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat',
                'typeDefinition',
                '"audioChannelFormat attributes [...] typeDefinition [...] Required [...] Yes"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat',
                'typeLabel',
                '"audioChannelFormat attributes [...] typeLabel [...] Required [...] Yes"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackUID',
                'UID',
                '"audioTrackUID attributes [...] UID [...] Required [...] Yes"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackUID',
                'sampleRate',
                '"audioTrackUID attributes [...] sampleRate [...] Required [...] Yes"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackUID',
                'bitDepth',
                '"audioTrackUID attributes [...] bitDepth [...] Required [...] Yes"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackFormat',
                'audioTrackFormatID',
                '"audioTrackFormat attributes [...] audioTrackFormatID [...] Required [...] Yes"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackFormat',
                'audioTrackFormatName',
                '"audioTrackFormat attributes [...] audioTrackFormatName [...] Required [...] Yes"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackFormat',
                'formatLabel',
                '"audioTrackFormat attributes [...] formatLabel [...] Required [...] Yes"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackFormat',
                'formatDefinition',
                '"audioTrackFormat attributes [...] formatDefinition [...] Required [...] Yes"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioStreamFormat',
                'audioStreamFormatID',
                '"audioStreamFormat attributes [...] audioStreamFormatID [...] Required [...] Yes"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioStreamFormat',
                'audioStreamFormatName',
                '"audioStreamFormat attributes [...] audioStreamFormatName [...] Required [...] Yes"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'formatLabel',
                '"audioStreamFormat attributes [...] formatLabel [...] Required [...] Yes"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'formatDefinition',
                '"audioStreamFormat attributes [...] formatDefinition [...] Required [...] Yes"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat/audioBlockFormat',
                'audioBlockFormatID',
                '"audioBlockFormat attributes [...] audioBlockFormatID [...] Required [...] Yes"'
            ),
        ]
    ),
    new Check(
        '<code>(attribute name)</code> attribute is present<code> (extra spec name if needed)</code>',
        'Error',
        [
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'typeLabel',
                '"Known issues with Dolby Atmos Master ADM files [...] audioProgramme [...] typeLabel [...] This attribute is present only in the appropriate elements"',
                'Update the encoder to write this element, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioContent',
                'typeLabel',
                '"Known issues with Dolby Atmos Master ADM files [...] audioContent [...] typeLabel [...] This attribute is present only in the appropriate elements"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackUID',
                'typeLabel',
                '"Known issues with Dolby Atmos Master ADM files [...] audioTrackUID [...] typeLabel [...] This attribute is present only in the appropriate elements"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackFormat',
                'typeLabel',
                '"Known issues with Dolby Atmos Master ADM files [...] audioTrackFormat [...] typeLabel [...] This attribute is present only in the appropriate elements"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackFormat',
                'typeDefinition',
                '"Known issues with Dolby Atmos Master ADM files [...] audioTrackFormat [...] typeDefinition [...] This attribute is present only in the appropriate elements"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'typeLabel',
                '"Known issues with Dolby Atmos Master ADM files [...] audioStreamFormat [...] typeLabel [...] This attribute is present only in the appropriate elements"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'typeDefinition',
                '"Known issues with Dolby Atmos Master ADM files [...] audioStreamFormat [...] typeDefinition [...] This attribute is present only in the appropriate elements"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'lstart',
                'audioBlockFormat requirements [...] rtime [...] This attribute shall not be used for DirectSpeakers type'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'duration',
                'audioBlockFormat requirements [...] duration [...] This attribute shall not be used for DirectSpeakers type'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'rtime',
                'This field is from S-ADM and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'lduration',
                'This field is from S-ADM and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'initializeBlock',
                'This field is from S-ADM and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat/position',
                'bound',
                'This field is not listed in the spec'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat/position',
                'screenEdgeLock',
                '"The screenEdgeLock attribute of the position subelement shall not be used"'
            ),
        ]
    ),
    new Check(
        '<code>(element name)</code> element is not present<code> (extra spec name if needed)</code>',
        'Error',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioProgramme',
                'audioContentIDRef',
                '"audioProgramme elements [...] audioContentIDRef [...] Quantity [...] 1...*"',
                'Update the encoder to write this element, then reencode the content.'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioContent',
                'audioObjectIDRef',
                '"audioContent elements [...] audioObjectIDRef [...] Quantity [...] 1...*"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioContent',
                'dialogue',
                '"audioContent elements [...] dialogue [...] Quantity [...] 1"',
                'Update the encoder to write this element, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'audioPackFormatIDRef',
                '"audioObject elements [...] audioPackFormatIDRef [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'audioTrackUIDRef',
                '"audioObject elements [...] audioTrackUIDRef [...] Quantity [...] 1 to"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'audioChannelFormatIDRef',
                '"audioPackFormat elements [...] audioChannelFormatIDRef [...] Quantity [...] 1 to"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat',
                'audioChannelFormat/audioBlockFormat',
                '"audioChannelFormat elements [...] audioBlockFormat [...] Quantity [...] 1...*"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackUID',
                'audioTrackFormatIDRef',
                '"audioTrackUID elements [...] audioTrackFormatIDRef [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackUID',
                'audioPackFormatIDRef',
                '"audioTrackUID elements [...] audioPackFormatIDRef [...] Quantity [...] 1"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackFormat',
                'audioStreamFormatIDRef',
                '"audioTrackFormat elements [...] audioStreamFormatIDRef [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'audioChannelFormatIDRef',
                '"audioStreamFormat elements [...] audioChannelFormatIDRef [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'audioPackFormatIDRef',
                '"audioStreamFormat elements [...] audioPackFormatIDRef [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'audioTrackFormatIDRef',
                '"audioStreamFormat elements [...] audioTrackFormatIDRef [...] Quantity [...] 1"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat/audioBlockFormat',
                'cartesian',
                '"audioBlockFormat elements [...] cartesian [...] Default [...] 0" with cartesian positions'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'cartesian',
                '"audioBlockFormat elements [...] cartesian [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'speakerLabel',
                '"audioBlockFormat elements [...] speakerLabel [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'position',
                '"audioBlockFormat Objects type subelement requirements [...] position [...] Quantity [...]" then "1" for "X" and "Y", "0 or 1" for Z'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat/audioBlockFormat',
                'position',
                '"audioBlockFormat sub-elements [...] position [...] Default [...] (empty)"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'width',
                '"audioBlockFormat elements [...] width [...] Quantity [...] 1"'
            ),
        ]
    ),
    new Check(
        '<code>(element name)</code> element is present<code> (extra spec name if needed)</code>',
        'Error',
        [
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'audioProgrammeLabel',
                'This field is from ADM v2 and not listed in the specification',
                'Update the encoder to write this element, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'authoringInformation',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'referenceLayout',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'audioPackFormatIDRef',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'alternativeValueSetIDRef',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioContent',
                'audioContentLabel',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioContent',
                'alternativeValueSetIDRef',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'audioObjectIDRef',
                '"audioObject elements [...] audioObjectIDRef [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'audioObjectLabel',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'audioComplementaryObjectGroupLabel',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'audioComplementaryObjectIDRef',
                '"audioObject elements [...] audioComplementaryObjectIDRef [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'audioObjectInteraction',
                '"audioObject elements [...] audioObjectInteraction [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'gain',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'headLocked',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'positionOffset',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'mute',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'alternativeValueSet',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'audioPackFormatIDRef',
                '"audioPackFormat elements [...] audioPackFormatIDRef [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'absoluteDistance',
                '"audioPackFormat elements [...] absoluteDistance [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'encodePackFormatIDRef',
                '"audioPackFormat elements [...] encodePackFormatIDRef [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'decodePackFormatIDRef',
                '"audioPackFormat elements [...] decodePackFormatIDRef [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'inputPackFormatIDRef',
                '"audioPackFormat elements [...] inputPackFormatIDRef [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'outputPackFormatIDRef',
                '"audioPackFormat elements [...] outputPackFormatIDRef [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'normalization',
                '"audioPackFormat elements [...] normalization [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'nfcRefDist',
                '"audioPackFormat elements [...] nfcRefDist [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'screenRef',
                '"audioPackFormat elements [...] screenRef [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat',
                'frequency',
                '"audioChannelFormat elements [...] frequency [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackUID',
                'audioMXFLookUp',
                '"audioTrackUID elements [...] audioMXFLookUp [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackUID',
                'audioChannelFormatIDRef',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'headLocked',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'headphoneVirtualise',
                'This field is from ADM v2 and not listed in the specification'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'outputChannelFormatIDRef',
                '"audioBlockFormat elements [...] outputChannelFormatIDRef [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'outputChannelIDRef,',
                '"audioBlockFormat elements [...] outputChannelIDRef, [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'jumpPosition',
                '"audioBlockFormat elements [...] jumpPosition [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'matrix',
                '"audioBlockFormat elements [...] matrix [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'coefficient',
                '"audioBlockFormat elements [...] coefficient [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'objectDivergence',
                '"audioBlockFormat elements [...] objectDivergence [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'equation',
                '"audioBlockFormat elements [...] equation [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'order',
                '"audioBlockFormat elements [...] order [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'degree',
                '"audioBlockFormat elements [...] degree [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'normalization',
                '"audioBlockFormat elements [...] normalization [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'nfcRefDist',
                '"audioBlockFormat elements [...] nfcRefDist [...] Quantity [...] 0"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'screenRef',
                '"audioBlockFormat elements [...] screenRef [...] Quantity [...] 0"'
            ),
        ]
    ),
    new Check(
        '<code>(element name)</code> element should not be present<code> (extra spec name if needed)</code>',
        'Warning',
        [
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat',
                'frequency',
                '"audioChannelFormat subelement requirements [...] frequency [...] This subelement should not be used"',
                'Update the encoder to write this element, then reencode the content.'
            ),
        ]
    ),
    new Check(
        '<code>(subelement name)</code> subelement count <code>(subelement count)</code> is not permitted, <code>(min or max)</code> is <code>(max count)</code><code> (extra spec name if needed)</code>',
        'Error',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackFormat',
                'audioStreamFormatIDRef',
                '"audioTrackFormat elements [...] audioStreamFormatIDRef [...] Quantity [...] 1"',
                'Update the encoder to write this element, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                null,
                '"audioChannelFormat subelement requirements [...] audioBlockFormat [...] 1 (for type DirectSpeakers)"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'loudnessMetadata',
                '"audioProgramme elements [...] loudnessMetadata [...] Quantity [...] 0 or 1"',
                'Update the encoder to write this element, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'audioProgrammeReferenceScreen',
                '"audioProgramme elements [...] audioProgrammeReferenceScreen [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'authoringInformation',
                '"audioProgramme elements [...] authoringInformation [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'audioContentIDRef',
                '"audioProgramme elements [...] audioContentIDRef  [...] 1 to MAX_ELEMENT_COUNT"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioContent',
                'loudnessMetadata',
                '"audioContent elements [...] loudnessMetadata [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioContent',
                'dialogue',
                '"audioContent elements [...] dialogue [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'audioPackFormatIDRef',
                '"audioObject elements [...] audioPackFormatIDRef [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'audioObjectInteraction',
                '"audioObject elements [...] audioObjectInteraction [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'gain',
                '"audioObject elements [...] gain [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'headLocked',
                '"audioObject elements [...] headLocked [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'positionOffset',
                '"audioObject elements [...] positionOffset [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'mute',
                '"audioObject elements [...] mute [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'absoluteDistance',
                '"audioPackFormat elements [...] absoluteDistance [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'inputPackFormatIDRef',
                '"audioPackFormat elements [...] inputPackFormatIDRef [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'outputPackFormatIDRef',
                '"audioPackFormat elements [...] outputPackFormatIDRef [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'normalization',
                '"audioPackFormat elements [...] normalization [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'nfcRefDist',
                '"audioPackFormat elements [...] nfcRefDist [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'screenRef',
                '"audioPackFormat elements [...] screenRef [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackUID',
                'audioMXFLookUp',
                '"audioTrackUID elements [...] audioMXFLookUp [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackUID',
                'audioTrackFormatIDRef',
                '"audioTrackUID elements [...] audioTrackFormatIDRef [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackUID',
                'audioChannelFormatIDRef',
                '"audioTrackUID elements [...] audioChannelFormatIDRef [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackUID',
                'audioPackFormatIDRef',
                '"audioTrackUID elements [...] audioPackFormatIDRef [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'audioChannelFormatIDRef',
                '"audioStreamFormat elements [...] audioChannelFormatIDRef [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'audioPackFormatIDRef',
                '"audioStreamFormat elements [...] audioPackFormatIDRef [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'audioTrackFormatIDRef',
                '"audioStreamFormat elements [...] audioTrackFormatIDRef [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'gain',
                '"audioBlockFormat elements [...] gain [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'importance',
                '"audioBlockFormat elements [...] importance [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'headLocked',
                '"audioBlockFormat elements [...] headLocked [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'headphoneVirtualise',
                '"audioBlockFormat elements [...] headphoneVirtualise [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'speakerLabel',
                '"audioBlockFormat elements [...] speakerLabel [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'outputChannelFormatIDRef',
                '"audioBlockFormat elements [...] outputChannelFormatIDRef [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'outputChannelIDRef,',
                '"audioBlockFormat elements [...] outputChannelIDRef, [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'jumpPosition',
                '"audioBlockFormat elements [...] jumpPosition [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'matrix',
                '"audioBlockFormat elements [...] matrix [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'coefficient',
                '"audioBlockFormat elements [...] coefficient [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'width',
                '"audioBlockFormat elements [...] width [...] Quantity [...] 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'depth',
                '"audioBlockFormat elements [...] depth [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'height',
                '"audioBlockFormat elements [...] height [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'cartesian',
                '"audioBlockFormat elements [...] cartesian [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'diffuse',
                '"audioBlockFormat elements [...] diffuse [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'channelLock',
                '"audioBlockFormat elements [...] channelLock [...] Quantity [...] 0 or 1"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'zoneExclusion',
                '"audioBlockFormat elements [...] zoneExclusion [...] Quantity [...] 0 or 1"'
            ),
        ]
    ),
    new Check(
        '<code>(element name)</code> <code>(topic name)</code> value <code>(actual value)</code> is not permitted, permitted value<code>(permitted values)</code><code> (extra spec name if needed)</code>',
        'Error',
        [
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'audioProgrammeID',
                '"audioProgrammeID This attribute shall be APR_1001"',
                'Configure or update the encoder to write this value, then reencode the content.'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat/audioBlockFormat',
                'cartesian',
                '"cartesian [...] 1/0 flag"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat/audioBlockFormat',
                'depth',
                '"depth [...] Relative Units (0 to 1)" or "depth [...] Ratio (0 to 1)"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat/audioBlockFormat',
                'width',
                '"width [...] Relative Units (0 to 1)" or "width [...] degrees (0 to 360)"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat/audioBlockFormat',
                'height',
                '"height [...] Relative Units (0 to 1)" or "height [...] degrees (0 to 360)"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackUID',
                'UID',
                '"UID [...] This attribute shall be ATU_nnnnnnnn, where nnnnnnnn is a unique hex value in range [0x00000001,0xFFFFFFFF]"',
                'Configure or update the encoder to write this value, then reencode the content.'
            ),
        ]
    ),
    new Check(
        '<code>(element name)</code> element count <code>(element count)</code> is not permitted, <code>(min or max)</code> is <code>(max count)</code><code> (extra spec name if needed)</code>',
        'Error',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioProgramme',
                null,
                'For min, common sense, entry point is audioProgramme',
                'Update the encoder to create an audioProgramme element, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                null,
                '"XML element [...] Maximum count [...] audioProgramme [...] 1"',
                'Configure or update the encoder to conform to this limitation, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioContent',
                null,
                '"XML element [...] Maximum count [...] audioContent [...] MAX_ELEMENT_COUNT"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                null,
                '"XML element [...] Maximum count [...] audioObject [...] MAX_ELEMENT_COUNT" or "objects (typeDefinition=”Objects”) [...] there shall be a maximum of 118 objects"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                null,
                '"XML element [...] Maximum count [...] audioPackFormat [...] MAX_ELEMENT_COUNT"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat',
                null,
                '"XML element [...] Maximum count [...] audioChannelFormat [...] MAX_CHANNEL_COUNT"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                null,
                '"XML element [...] Maximum count [...] audioStreamFormat [...] MAX_CHANNEL_COUNT"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackFormat',
                null,
                '"XML element [...] Maximum count [...] audioTrackFormat [...] MAX_CHANNEL_COUNT"'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackUID',
                null,
                '"XML element [...] Maximum count [...] audioTrackUID [...] MAX_CHANNEL_COUNT"'
            ),
        ],
        [ 'General_compliance']
    ),
    new Check(
        '<code>(element name)</code> value <code>(element value)</code> shall match the <code>(target attribue name)</code> attribute of a<code>(target element name)</code> element',
        'Error',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioProgramme',
                'audioContentIDRef',
                'Common sense: impossible to know what to do with the content without its description',
                'Update the encoder to write the expected content, then reencode the content.'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioProgramme',
                'audioPackFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioProgramme',
                'alternativeValueSetIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioContent',
                'audioObjectIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioContent',
                'alternativeValueSetIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioObject',
                'audioPackFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioObject',
                'audioObjectIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioObject',
                'audioComplementaryObjectIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioObject',
                'audioTrackUIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioObject',
                'audioComplementaryObjectIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioObject',
                'audioTrackUIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                'audioChannelFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                'encodePackFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                '',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                'decodePackFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                'inputPackFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                'outputPackFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackUID',
                'audioTrackFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackUID',
                'audioChannelFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackUID',
                'audioPackFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackFormat',
                'audioStreamFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioStreamFormat',
                'audioChannelFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioStreamFormat',
                'audioPackFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioStreamFormat',
                'audioTrackFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat/audioBlockFormat',
                'outputChannelFormatIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat/audioBlockFormat',
                'outputChannelIDRef',
                'Common sense: impossible to know what to do with the content without its description'
            ),
        ]
    ),
    new Check(
        '<code>(element name)</code> value <code>(element value)</code> shall be unique',
        'Error',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioProgramme',
                'audioProgrammeID',
                '"Use of IDs [...] provide a unique identification"',
                'Update the encoder to avoid duplicate ID values, then reencode the content.'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioContent',
                'audioContentID',
                '"Use of IDs [...] provide a unique identification"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioObject',
                'audioObjectID',
                '"Use of IDs [...] provide a unique identification"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                'audioPackFormatID',
                '"Use of IDs [...] provide a unique identification"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat',
                'audioChannelFormatID',
                '"Use of IDs [...] provide a unique identification"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackUID',
                'UID',
                '"Use of IDs [...] provide a unique identification"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackFormat',
                'audioTrackFormatID',
                '"Use of IDs [...] provide a unique identification"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioStreamFormat',
                'audioStreamFormatID',
                '"Use of IDs [...] provide a unique identification"'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat/audioBlockFormat',
                'audioBlockFormatID',
                '"Use of IDs [...] provide a unique identification"'
            ),
        ]
    ),
    new Check(
        '<code>(attribute name)</code> attribute with <code>(substring)</code> value <code>(attribute value)</code> not same as <code>(attribute name)</code> attribute <code>(substring)</code> value <code>(attribute value)</code><code> (extra spec name if needed)</code>',
        'Error',
        [
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'audioBlockFormatID',
                '"audioBlockFormat requirements [...] audioBlockFormatID [...] where xxxx is a unique hex value matching the parent audioChannelFormat value"',
                'Update the encoder to write the expected content, then reencode the content.'
            ),
        ]
    ),
    new Check(
        '<code>(attribute name)</code> attribute with <code>(substring)</code> value <code>(attribute value)</code> not same as <code>(attribute name)</code> attribute <code>(substring)</code> value <code>(attribute value)</code>',
        'Warning',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat/audioBlockFormat',
                'audioBlockFormatID',
                '"In audioBlockFormat [...] The yyyyxxxx values should match those of the parent audioChannelFormat ID"',
                'Update the encoder to write the expected content, then reencode the content.'
            ),
        ]
    ),
    new Check(
        '<code>(subelement name)</code> subelement with <code>(substring)</code> value <code>(subelement value)</code> not same as <code>(attribute name)</code> attribute <code>(substring)</code> value <code>(attribute value)</code><code> (extra spec name if needed)</code>',
        'Error',
        [
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'audioChannelFormatIDRef',
                '"audioPackFormat subelement [...] audioChannelFormatIDRef [...] This subelement shall match the audioChannelFormatID of the corresponding audioChannelFormat"',
                'Update the encoder to write the expected content, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackFormat',
                'audioStreamFormatIDRef',
                '"audioTrackFormat subelement [...] audioStreamFormatIDRef [...] This subelement shall match the audioStreamFormatID of the corresponding audioStreamFormat"'
            ),
        ]
    ),
    new Check(
        '<code>(subelement name)</code> subelement with <code>(substring)</code> value <code>(subelement value)</code> not same as <code>(attribute name)</code> attribute <code>(substring)</code> value <code>(attribute value)</code>',
        'Warning',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioStreamFormat',
                'audioChannelFormatIDRef',
                '"audioStreamFormat attributes [...] audioStreamFormatID [...] The xxxx digits should match the audioChannelFormat xxxx digits."',
                'Update the encoder to write the expected content, then reencode the content.'
            ),
        ]
    ),
    new Check(
        '<code>(attribute name)</code> attribute value <code>(attribute value)</code> is not a valid form (<code>(the valid form)</code>)',
        'Error',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackFormat',
                'formatLabel',
                '"typeDefinitions [...] typeLabel [...] to Fyyy"',
                'Update the encoder to write the expected content, then reencode the content.'
            ),
        ]
    ),
    new Check(
        '<code>(attribute name)</code> attribute value <code>(attribute value)</code> is not a known value',
        'Warning',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                'typeLabel',
                '"typeDefinitions [...] typeDefinition [...] typeLabel" (table with a list of known values)',
                'Check that this is intended'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                'formatDefinition',
                '"typeDefinitions [...] typeDefinition [...] typeLabel" (table with a list of known values)'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat',
                'typeLabel',
                '"typeDefinitions [...] typeDefinition [...] typeLabel" (table with a list of known values)'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat',
                'formatDefinition',
                '"typeDefinitions [...] typeDefinition [...] typeLabel" (table with a list of known values)',
                'Check that this is intended'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackFormat',
                'typeLabel',
                '"typeDefinitions [...] typeDefinition [...] typeLabel" (table with a list of known values)'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackFormat',
                'formatDefinition',
                '"typeDefinitions [...] typeDefinition [...] typeLabel" (table with a list of known values)',
                'Check that this is intended'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioStreamFormat',
                'typeLabel',
                '"typeDefinitions [...] typeDefinition [...] typeLabel" (table with a list of known values)'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioStreamFormat',
                'formatDefinition',
                '"typeDefinitions [...] typeDefinition [...] typeLabel" (table with a list of known values)',
                'Check that this is intended'
            ),
        ]
    ),
    new Check(
        '<code>(attribute name)</code> attribute value <code>(attribute value)</code> shall be <code>(expected value)</code> in order to match the term corresponding to <code>(other attribute name)</code> attribute value <code>(other attribute value)</code>',
        'Error',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                'typeLabel',
                '"typeDefinitions [...] typeDefinition [...] typeLabel" (table with both value on the same line)',
                'Update the encoder to write the expected content, then reencode the content.'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                'typeDefinition',
                '"typeDefinitions [...] typeDefinition [...] typeLabel" (table with both value on the same line)'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat',
                'typeLabel',
                '"typeDefinitions [...] typeDefinition [...] typeLabel" (table with both value on the same line)'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat',
                'typeDefinition',
                '"typeDefinitions [...] typeDefinition [...] typeLabel" (table with both value on the same line)'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackFormat',
                'formatLabel',
                '"formatDefinitions [...] formatDefinition [...] formatLabel" (table with both value on the same line)'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackFormat',
                'formatDefinition',
                '"formatDefinitions [...] formatDefinition [...] formatLabel" (table with both value on the same line)'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioStreamFormat',
                'formatLabel',
                '"formatDefinitions [...] formatDefinition [...] formatLabel" (table with both value on the same line)'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioStreamFormat',
                'formatDefinition',
                '"formatDefinitions [...] formatDefinition [...] formatLabel" (table with both value on the same line)'
            ),
        ]
    ),
    new Check(
        '<code>(attribute name)</code> attribute value <code>(attribute value)</code> is not permitted, permitted value<code>(permitted values)</code><code> (extra spec name if needed)</code>',
        'Error',
        [
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'typeLabel',
                '"audioPackFormat attribute requirements [...] typeLabel [...] This attribute shall be either 0001 or 0003"',
                'Configure or update the encoder to write the expected content, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'formatDefinition',
                '"audioPackFormat attribute requirements [...] formatDefinition [...] This attribute shall be either DirectSpeakers or Objects."'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat',
                'typeLabel',
                '"audioChannelFormat attribute requirements [...] typeLabel [...] The label shall be either 0001 or 0003."',
                'Configure or update the encoder to write the expected content, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat',
                'formatDefinition',
                '"audioChannelFormat attribute requirements [...] formatDefinition [...] The definition shall be either DirectSpeakers or Objects"',
                'Configure or update the encoder to write the expected content, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackFormat',
                'formatLabel',
                '"audioTrackFormat attribute requirements [...] formatLLabel [...] This label shall be 0001"',
                'Configure or update the encoder to write the expected content, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackFormat',
                'formatDefinition',
                '"audioTrackFormat attribute requirements [...] formatDefinition [...] This definition shall be PCM"',
                'Configure or update the encoder to write the expected content, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'formatLabel',
                '"audioStreamFormat attribute requirements [...] formatLabel [...] This label shall be 0001"',
                'Configure or update the encoder to write the expected content, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'formatDefinition',
                '"audioStreamFormat attribute requirements [...] formatDefinition [...] This definition shall be PCM"',
                'Configure or update the encoder to write the expected content, then reencode the content.'
            ),
        ]
    ),
    new Check(
        '<code>(subelement name)</code> order <code>(computed target order)</code> is not permitted<code> (extra spec name if needed)</code>',
        'Error',
        [
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'audioChannelFormatIDRef',
                '"only certain channel configuration sets shall be used, with each set having a specific ordering of channels"',
                'Configure or update the encoder to write the expected content, then reencode the content.'
            ),
        ]
    ),
    new Check(
        '<code>(attribute name)</code> attribute value <code>(attribute value)</code> is long<code> (extra spec name if needed)</code>',
        'Warning',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioProgramme',
                'audioProgrammeName',
                'Common sense: it is difficult to display it in an UI',
                'Configure the encoder to write a shorter name, then reencode the content.'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioContent',
                'audioContentName',
                'Common sense: it is difficult to display it in an UI'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioObject',
                'audioObjectName',
                'Common sense: it is difficult to display it in an UI'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                'audioPackFormatName',
                'Common sense: it is difficult to display it in an UI'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat',
                'audioChannelFormatName',
                'Common sense: it is difficult to display it in an UI'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackFormat',
                'audioTrackFormatName',
                'Common sense: it is difficult to display it in an UI'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioStreamFormat',
                'audioStreamFormatName',
                'Common sense: it is difficult to display it in an UI'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'audioProgrammeName',
                '"audioProgramme attribute requirements" [...] audioProgrammeName [...] max length should not exceed 64 chars',
                'Configure the encoder to write a shorter name, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioContent',
                'audioContentName',
                '"audioContent attribute requirements" [...] audioProgrammeName [...] max length should not exceed 64 chars'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'audioObjectName',
                '"audioObject attribute requirements" [...] audioProgrammeName [...] max length should not exceed 64 chars'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'audioPackFormatName',
                '"audioPackFormat attribute requirements" [...] audioProgrammeName [...] max length should not exceed 64 chars'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat',
                'audioChannelFormatName',
                '"audioChannelFormat attribute requirements" [...] audioProgrammeName [...] max length should not exceed 64 chars'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackFormat',
                'audioTrackFormatName',
                '"audioTrackFormat attribute requirements" [...] audioProgrammeName [...] max length should not exceed 64 chars'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'audioStreamFormatName',
                '"audioStreamFormat attribute requirements" [...] audioProgrammeName [...] max length should not exceed 64 chars'
            ),
        ]
    ),
    new Check(
        '<code>(attribute name)</code> attribute is present but empty',
        'Error',
        [
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioProgramme',
                'audioProgrammeName',
                '"audioProgramme attribute requirements" [...] audioProgrammeName [...] Min length 1 char',
                'Configure the encoder to write a relevant name, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioContent',
                'audioContentName',
                '"audioContent attribute requirements" [...] audioProgrammeName [...] Min length 1 char'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioObject',
                'audioObjectName',
                '"audioObject attribute requirements" [...] audioProgrammeName [...] Min length 1 char'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioPackFormat',
                'audioPackFormatName',
                '"audioPackFormat attribute requirements" [...] audioProgrammeName [...] Min length 1 char'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat',
                'audioChannelFormatName',
                '"audioChannelFormat attribute requirements" [...] audioProgrammeName [...] Min length 1 char'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioTrackFormat',
                'audioTrackFormatName',
                '"audioTrackFormat attribute requirements" [...] audioProgrammeName [...] Min length 1 char'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioStreamFormat',
                'audioStreamFormatName',
                '"audioStreamFormatName attribute requirements" [...] audioProgrammeName [...] Min length 1 char'
            ),
        ]
    ),
    new Check(
        '<code>(attribute name)</code> attribute is present but empty',
        'Warning',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioProgramme',
                'audioProgrammeName',
                'Common sense: it is not useful for the operator to have an empty value',
                'Configure the encoder to write a relevant name, then reencode the content.'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioContent',
                'audioContentName',
                'Common sense: it is not useful for the operator to have an empty value'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioObject',
                'audioObjectName',
                'Common sense: it is not useful for the operator to have an empty value'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioPackFormat',
                'audioPackFormatName',
                'Common sense: it is not useful for the operator to have an empty value'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat',
                'audioChannelFormatName',
                'Common sense: it is not useful for the operator to have an empty value'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioTrackFormat',
                'audioTrackFormatName',
                'Common sense: it is not useful for the operator to have an empty value'
            ),
            new Reference(
                'ITU-R_BS.2076',
                'audioStreamFormat',
                'audioStreamFormatName',
                'Common sense: it is not useful for the operator to have an empty value'
            ),
        ]
    ),
    new Check(
        '<code>(element name)</code> element value <code>(element value)</code> does not match corresponding<code>(element name)</code> element value <code>(element value)</code><code> (extra spec name if needed)</code>',
        'Error',
        [
            new Reference(
                'ITU-R_BS.2076',
                'audioChannelFormat/audioBlockFormat',
                'position'
            ),
        ]
    ),
    new Check(
        '<code>(element names)</code> elements are not all present<code> (extra spec name if needed)</code>',
        'Error',
        [
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                null,
                '"If any size sub-elements [width, depth, height] are present, then all three sub-elements must be present and set to the same value"',
                'Configure the encoder to write a same values, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'width'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'height'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'depth'
            ),
        ]
    ),
    new Check(
        '<code>(element names)</code> element values are not same<code> (extra spec name if needed)</code>',
        'Error',
        [
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                null,
                '"If any size sub-elements [width, depth, height] are present, then all three sub-elements must be present and set to the same value"',
                'Configure the encoder to write a same values, then reencode the content.'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'width'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'height'
            ),
            new Reference(
                'Dolby_Atmos_Master_ADM_Profile',
                'audioChannelFormat/audioBlockFormat',
                'depth'
            ),
        ]
    ),
];

$GLOBALS['dbFormatToSpecs'] =
[
    'AC-3' => [ 'ETSI_TS_102_366' ],
    'DRC' => [ 'ISO_IEC_23003-4' ],
    'E-AC-3' => [ 'ETSI_TS_102_366' ],
    'MP4' => [ 'ISO_IEC_14496-1', 'ISO_IEC_14496-3', 'ISO_IEC_14496-12' ],
    'USAC' => [ 'ISO_IEC_23003-3', 'ISO_IEC_23003-4' ],
    'ADM' => [ 'ITU-R_BS.2076', 'Dolby_Atmos_Master_ADM_Profile' ],
];

$GLOBALS['dbProfileToSpec'] =
[
    'Dolby_Atmos_Master_ADM_Profile' => 'ITU-R_BS.2076',
];

function is_spec_in_formats($specId, $formats)
{
    global $dbFormatToSpecs;

    foreach ($formats as $format) {
        if (in_array($specId, $dbFormatToSpecs[$format])) {
            return true;
        }
    }
    
    return false;
}

/**
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
function get_references($checkId, $urlPrefix, $formats = null, $elementId = null, $fieldId = null)
{
    $dbSpecs = (new Specs)->getSpecs();
    global $dbChecks;
    global $dbProfileToSpec;
    
    foreach ($dbChecks[$checkId]->references as $checkToDetail) {
        if ((!$formats || is_spec_in_formats($checkToDetail->specId, $formats)) && (!$elementId || $elementId == end(explode('/', $checkToDetail->elementId))) && (!$fieldId || $fieldId == $checkToDetail->fieldId)) {
            $spec = $dbSpecs[$checkToDetail->specId];
            if ($spec) {
                $url = $urlPrefix . 'Specs/';
                if (array_key_exists($checkToDetail->specId, $dbProfileToSpec)) {
                    $url .= $dbProfileToSpec[$checkToDetail->specId];
                } else {
                    $url .= $checkToDetail->specId;
                }
                $name = $checkToDetail->specId;
                $description = null;
                if ($checkToDetail->elementId) {
                    $url .= '/' . $checkToDetail->elementId;
                    $name = $checkToDetail->elementId;
                    $element = $spec->elements[$checkToDetail->elementId];
                    if ($element->description) {
                        $description = '"' . $element->description . '"';
                    }
                    if ($checkToDetail->fieldId) {
                        $url .= '/' . $checkToDetail->fieldId;
                        $name = $checkToDetail->fieldId;
                        $field = $element->fields[$checkToDetail->fieldId];
                        if ($field->description) {
                            $description = '"' . $field->description . '"';
                        }
                    }
                }
                if ($checkToDetail->reason) {
                    $description = $checkToDetail->reason;
                }
                if ($spec->flags & 1) {
                    $name = str_replace('_', ' ', $name);
                }
                $specItem = '<a href="' . $url . '"><code>' . $name . '</code></a>';
                if ($description) {
                    $specItem .= ': ' . $description;
                }
            
                $temp[$checkToDetail->specId][] =  $specItem;
            }
        }
    }
    
    foreach ($temp as $key => $value) {
        $references[] = [ '<a href="' . $urlPrefix . 'Specs/' . $key . '">' . str_replace('_', ' ', $key) . '</a>' . ($dbSpecs[$key]->shortName ? (' (' . $dbSpecs[$key]->shortName . ')') : ''), $value ];
    }
    
    return $references;
}

function get_references_from_crosscheck_message($index, $message)
{
    // Format
    $pos2 = strpos($message, ' ', $pos);
    if ($pos2 === false) {
        return null;
    }
    $format = substr($message, $pos, $pos2 - $pos);
    $pos = $pos2 + 1;

    // elementId
    $pos2 = strpos($message, ' ', $pos);
    if ($pos2 === false) {
        return null;
    }
    $elementId = substr($message, $pos, $pos2 - $pos);
    $pos = $pos2 + 1;

    // fieldId
    $pos2 = strpos($message, ' ', $pos);
    if ($pos2 === false) {
        return null;
    }
    $fieldId = substr($message, $pos, $pos2 - $pos);

    return get_references($index, '', [ $format ], $elementId, $fieldId);
}

function get_crosscheck_second_part_pos($message)
{
    $pos = strpos($message, ' does not match ');
    if ($pos !== false) {
        return $pos + 16;
    }
    $pos = strpos($message, ' does not permit ');
    if ($pos !== false) {
        return $pos + 17;
    }
    return false;
}

function get_message_complexity($messageParts)
{
    $countOfChars = 0;
    foreach ($messageParts as $part) {
        $countOfChars += strlen($part);
    }
    return $countOfChars;
}

/**
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
function map_message_to_references($formats, $groupId, $elementId, $fieldId, $message)
{
    if (!is_string($elementId) || (isset($fieldId) && !is_string($fieldId)) || !is_string($message) || (isset($groupId) && !is_string($groupId))) {
        return null;
    }

    global $dbChecks;
    global $dbChecksSplitDescription;

    $errorsList [] = [ null, [ $message ] ];
    $previousCheckId = null;
    foreach ($dbChecksSplitDescription as $checkId => $checkItem) {
        // Check match between message and check item
        $pos = false;
        $shouldBeEnd = true;
        foreach ($checkItem as $checkItemPart) {
            if (empty($checkItemPart)) {
                if ($pos === false) {
                    $pos = 1;
                } else {
                    $pos++;
                }
                $shouldBeEnd = false;
            } else {
                $pos = strpos($message, $checkItemPart, $pos);
                if ($pos === false) {
                    break;
                }
                $pos += strlen($checkItemPart);
                $shouldBeEnd = true;
            }
        }
        if ($pos === false) {
            continue;
        }
        if ($shouldBeEnd && !($pos == strlen($message) || ($message[$pos] == ' ' && $message[$pos + 1] == '('))) {
            continue;
        }
        foreach ($dbChecks[$checkId]->references as $checkToDetail) {
            // Check match
            if ((!$formats || is_spec_in_formats($checkToDetail->specId, $formats)) && (!$elementId || $elementId == end(explode('/', $checkToDetail->elementId))) && (!$fieldId || $fieldId == $checkToDetail->fieldId)) {
                // Special case, if 2 matching item, ugly algo for selecting the best one
                if ($previousCheckId !== null) {
                    $previous = get_message_complexity($dbChecksSplitDescription[$previousCheckId]);
                    $current = get_message_complexity($checkItem);
                    if ($current < $previous) {
                        break;
                    }
                    array_splice($errorsList, 1);
                }
                $previousCheckId = $checkId;

                // Get references
                array_push($errorsList, ...get_references($checkId, '', $formats, $elementId, $fieldId));
                if ($groupId == "Crosscheck") {
                    // Looking for the second part of the crosscheck
                    $pos = get_crosscheck_second_part_pos($message);
                    if ($pos !== false) {
                        array_push($errorsList, ...get_references_from_crosscheck_message($checkId, substr($message, $pos)));
                    }
                }

                $errorsList [] = [ null, [ '<a href="Checks/' . $checkId . '">More information...</a>'] ];
            }
        }
    }

    $errorKey = ($groupId ? ('(' . str_replace('_', ' ', $groupId) . ') ') : null) . $elementId . ($fieldId ? ('/' . $fieldId) : null);

    return [ $errorKey, $errorsList ];
}

function map_messages_to_references($formats, $groupId, $elementId, $fieldId, $messages)
{
    foreach (explode(" / ", $messages) as $message) {
        $data [] = map_message_to_references($formats, $groupId, $elementId, $fieldId, $message);
    }
    
    return $data;
}

/**
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */

function manage_conformance_per_key($formats, $key0, $error0)
{
    $data = [];

    if (is_object($error0)) {
        foreach ($error0 as $key1 => $error1) {
            unset($groupId);
            if (is_object($error1)) {
                foreach ($error1 as $key2 => $error2) {
                    if (is_object($error2)) {
                        // Not supported
                    } else {
                        foreach ($error1 as $key2 => $error2) {
                            if ($key0 == "Crosscheck") {
                                $groupId = $key0;
                                $pos2 = strpos($error2, ' ');
                                if ($pos2 !== false) {
                                    $formats2 = [ substr($error2, 0, $pos2) ];
                                } else {
                                    $formats2 = null;
                                }
                                $elementId = '';
                            } else {
                                $elementId = $key0 . '/';
                                $formats2 = $formats;
                            }
                            $elementId .= $key1;
                            array_push($data, ...map_messages_to_references($formats2, $groupId, $elementId, $key2, $error2));
                        }
                    }
                }
            } else {
                if ($key1 == 'GeneralCompliance' || $key1 == 'General' ||  $key1 == 'Coherency') {
                    $groupId = 'General_compliance';
                    $fieldId = null;
                } else {
                    $fieldId = $key1;
                }
                array_push($data, ...map_messages_to_references($formats, $groupId, $key0, $fieldId, $error1));
            }
        }
    } else {
        array_push($data, ...map_messages_to_references($formats, null, $key0, null, $error0));
    }

    return $data;
}

/**
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */

function manage_conformance($formats, $conformance)
{
    $data = [];
    foreach ($conformance as $key0 => $error0) {
        if (is_array($error0)) {
            foreach ($error0 as $error0Value) {
                foreach ($error0Value as $key1 => $error1) {
                    if (is_array($error1)) {
                        foreach ($error1 as $error1Value) {
                            array_push($data, ...manage_conformance_per_key($formats, $key1, $error1Value));
                        }
                    } else {
                        array_push($data, ...manage_conformance_per_key($formats, $key0, $error1));
                    }
                }
            }
        } else {
            array_push($data, ...manage_conformance_per_key($formats, $key0, $error0));
        }
    }

    return $data;
}

/**
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class Checks
{
    public function analyzeMediaInfoReport($miReport)
    {
        global $dbChecks;
        global $dbChecksSplitDescription;
        foreach ($dbChecks as $check) {
            $checks = [];
            $pos = 0;
            $valueFound = false;
            $testLen = strlen($check->description);
            while (pos) {
                $pos2 = strpos($check->description, '<code>', $pos);
                if ($pos2 === false) {
                    $pos2 = $testLen;
                }
                if ($pos2 != $pos) {
                    $sub = substr($check->description, $pos, $pos2 - $pos);
                    if (count($checks) == 0 || $valueFound) {
                        $checks [] = $sub;
                    } else {
                        $checks [count($checks)-1] .= $sub;
                    }
                }
                if ($pos2 != $testLen && ($check->description[$pos2 + 6] == '(' || ($check->description[$pos2 + 6] == ' ' && $check->description[$pos2 + 7] == '('))) {
                    $pos = strpos($check->description, ')</code>', $pos2 + 1);
                    if ($pos === false) {
                        break;
                    }
                    $pos += 8;
                    $checks [] = null;
                    $valueFound = true;
                } else {
                    $pos = strpos($check->description, '</code>', $pos2 + 1);
                    if ($pos === false) {
                        break;
                    }
                    $pos2 += 6;
                    $sub = substr($check->description, $pos2, $pos - $pos2);
                    if (count($checks) == 0) {
                        $checks [] = $sub;
                    } else {
                        $checks [count($checks)-1] .= $sub;
                    }
                    $pos += 7;
                    $valueFound = false;
                }
            }
            $dbChecksSplitDescription [] = str_replace([ '&gt;', '&lt;' ], [ '>', '<' ], $checks);
        }
        
        $data = [];
        foreach (json_decode($miReport) as $media) {
            foreach ($media as $tracks) {
                unset($isNotFirst);
                foreach ($tracks as $track) {
                    if (!isset($isNotFirst) || $track->{'@type'} == "General") {
                        $generalFormat = $track->Format;
                        if ($generalFormat == "MPEG-4") {
                            $generalFormat = "MP4";
                        }
                    }
                    $isNotFirst = true;
                    if ($track->extra) {
                        $formats = [];
                        if (isset($track->extra) && isset($track->extra->Metadata_Format)) {
                            $metadataFormat = $track->extra->Metadata_Format;
                            $metadataFormatPos = strpos($metadataFormat, ",");
                            if ($metadataFormatPos !== false) {
                                $metadataFormat = substr($metadataFormat, 0, $metadataFormatPos);
                                if ($metadataFormat != $track->Format) {
                                    $formats [] = $metadataFormat;
                                }
                            }
                        }
                        $formats [] = $track->Format;
                        if ($generalFormat != $track->Format) {
                            $formats [] = $generalFormat;
                        }
                        if ($track->extra->ConformanceErrors) {
                            array_push($data, ...manage_conformance($formats, $track->extra->ConformanceErrors));
                        }
                        if ($track->extra->ConformanceWarnings) {
                            array_push($data, ...manage_conformance($formats, $track->extra->ConformanceWarnings));
                        }
                        if ($track->extra->ConformanceInfos) {
                            array_push($data, ...manage_conformance($formats, $track->extra->ConformanceInfos));
                        }
                    }
                }
            }
        }
        
        return $data;
    }

    public function listChecks()
    {
        global $dbChecks;
        
        // List
        foreach ($dbChecks as $checkId => $check) {
            $list[] = '<a href="Checks/' . $checkId . '">' . $check->description . '</a>';
        }
        $data [] = [ 'List of checks', [ [ null, $list ] ] ];
        
        return $data;
    }

    public function listCheckInfo($checkId)
    {
        global $dbChecks;
               
        if (!is_numeric($checkId)) {
            return null;
        }
        $checkId = intval($checkId);
        $check = $dbChecks[$checkId];
        if (!$check) {
            return null;
        }
       
        // Description
        $data [] = [ 'Description of the issue', [ [ null, [ $check->description ] ] ] ] ;

        // Groups
        foreach ($check->groups as $groupId) {
            $groups[] = [ null, [ '<a href="../Groups/' . $groupId . '">' . str_replace('_', ' ', $groupId) . '</a>' ] ];
        }
        if (!empty($groups)) {
            $data [] = [ 'Groups', $groups ];
        }
        
        // References
        $references = get_references($checkId, '../');
        if (!empty($references)) {
            $data [] = [ 'References', $references ];
        }

        // Actions
        foreach ($check->references as $reference) {
            if ($reference->action) {
                $actions[] = [ $reference->specId ? str_replace('_', ' ', $reference->specId) : null, [ $reference->action ] ];
            }
        }
        if (!empty($actions)) {
            $data [] = [ 'Possible solution/action', $actions ] ;
        }
        
        // Severity
        if (!empty($check->severityId)) {
            $data [] = [ 'Severity', [ null, [ '<a href="../Severities/' . $check->severityId . '">' . $check->severityId . '</a>' ] ] ] ;
        }
        
        // QC.EBU.IO
        foreach ($check->qcEbuIos as $qcEbuIo) {
            $qcEbuIoList[] = [ null, [ '<a href="../Specs/QC.EBU.IO/' . $qcEbuIo . '">' . str_replace('_', ' ', $qcEbuIo) . '</a> ' ] ];
        }
        if (!empty($qcEbuIo)) {
            $data [] = [ 'QC.EBU.IO Test Items', $qcEbuIoList ] ;
        }
      
        return $data;
    }

    public static function getSpecChecks($specId)
    {
        global $dbChecks;
        global $dbProfileToSpec;

        // Checks
        foreach ($dbChecks as $checkId => $check) {
            foreach ($check->references as $reference) {
                if ($reference->specId == $specId || $dbProfileToSpec[$reference->specId] == $specId) {
                    $references[] = '<a href="../Checks/' . $checkId . '">' . $check->description . '</a>' . ($reference->specId == $specId ? '' : (' (' . str_replace('_', ' ', $reference->specId) . ' addition)'));
                    break;
                }
            }
        }

        return $references;
    }

    public static function getSpecElementChecks($specId, $elementId, $urlPrefix)
    {
        global $dbChecks;
        global $dbProfileToSpec;
         
        // Checks
        $urlPrefix = '<a href="' . $urlPrefix . 'Checks/';
        if ($specId =="QC.EBU.IO") {
            foreach ($dbChecks as $checkID => $check) {
                foreach ($check->qcEbuIos as $qcEbuIo2) {
                    if ($qcEbuIo2 == $elementId) {
                        $checks[] = $urlPrefix . $checkID . '">' . $check->description . '</a>';
                    }
                }
            }
        } else {
            foreach ($dbChecks as $checkID => $check) {
                foreach ($check->references as $reference) {
                    if (($reference->specId == $specId || $dbProfileToSpec[$reference->specId] == $specId) && $reference->elementId == $elementId) {
                        $checks[] = $urlPrefix . $checkID . '">' . $check->description . '</a>' . ($reference->specId == $specId ? '' : (' (' . str_replace('_', ' ', $reference->specId) . ' addition)'));
                        break;
                    }
                }
            }
        }
        
        return $checks;
    }

    public static function getSpecFieldChecks($specId, $elementId, $fieldId, $urlPrefix)
    {
        global $dbChecks;
        global $dbProfileToSpec;
         
        // Checks
        $urlPrefix = '<a href="' . $urlPrefix . 'Checks/';
        foreach ($dbChecks as $checkID => $check) {
            foreach ($check->references as $reference) {
                if (($reference->specId == $specId || $dbProfileToSpec[$reference->specId] == $specId) && $reference->elementId == $elementId && $reference->fieldId == $fieldId) {
                    $checks[] = $urlPrefix . $checkID . '">' . $check->description . '</a>' . ($reference->specId == $specId ? '' : (' (' . str_replace('_', ' ', $reference->specId) . ' addition)'));
                    break;
                }
            }
        }

        return $checks;
    }

    public function getGroupChecks($groupId)
    {
        global $dbChecks;

        // Checks
        foreach ($dbChecks as $checkId => $check) {
            foreach ($check->groups as $groupId2) {
                if ($groupId2 == $groupId) {
                    $checks[] = '<a href="../Checks/' . $checkId . '">' . $check->description . '</a>';
                }
            }
        }
        
        return $checks;
    }

    public function getSeverityChecks($severityId)
    {
        global $dbChecks;
        
        // Checks
        foreach ($dbChecks as $checkId => $check) {
            if ($check->severityId == $severityId) {
                $checks[] = '<a href="../Checks/' . $checkId . '">' . $dbChecks[$checkId]->description . '</a>';
            }
        }

        return $checks;
    }
}
