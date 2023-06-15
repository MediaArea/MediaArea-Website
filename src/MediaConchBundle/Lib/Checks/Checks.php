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
        'Extra zero bytes after the end of the syntax was reached',
        'Warning',
        [
            new Reference(
                'ISO_IEC_23003-3',
                'AudioPreRoll',
                null,
                'Fix the muxer in order to correctly fill the impacted element, then reencode the content.'
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
        'Warning',
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
];

$GLOBALS['dbFormatToSpecs'] =
[
    'AC-3' => [ 'ETSI_TS_102_366' ],
    'DRC' => [ 'ISO_IEC_23003-4' ],
    'E-AC-3' => [ 'ETSI_TS_102_366' ],
    'MP4' => [ 'ISO_IEC_14496-1', 'ISO_IEC_14496-3', 'ISO_IEC_14496-12' ],
    'USAC' => [ 'ISO_IEC_23003-3', 'ISO_IEC_23003-4' ],
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
 */
function get_references($checkId, $urlPrefix, $formats = null, $elementId = null, $fieldId = null)
{
    $dbSpecs = (new Specs)->getSpecs();
    global $dbChecks;
    
    foreach ($dbChecks[$checkId]->references as $checkToDetail) {
        if ((!$formats || is_spec_in_formats($checkToDetail->specId, $formats)) && (!$elementId || $elementId == end(explode('/', $checkToDetail->elementId))) && (!$fieldId || $fieldId == $checkToDetail->fieldId)) {
            $spec = $dbSpecs[$checkToDetail->specId];
            if ($spec) {
                $url = $urlPrefix . 'Specs/' . $checkToDetail->specId;
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
        $references[] = [ '<a href="' . $urlPrefix . 'Specs/' . $key . '">' . str_replace('_', ' ', $key) . '</a> (' . $dbSpecs[$key]->shortName . ')', $value ];
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

function manage_conformance($formats, $conformance)
{
    $data = [];
    foreach ($conformance as $key0 => $error0) {
        if (is_object($error0)) {
            foreach ($error0 as $key1 => $error1) {
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
                    if ($key1 != 'GeneralCompliance' || $key1 == 'Coherency') {
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
                if ($pos2 != $testLen && $check->description[$pos2 + 6] == '(') {
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
                foreach ($tracks as $track) {
                    if ($track->{'@type'} == "General") {
                        $generalFormat = $track->Format;
                        if ($generalFormat == "MPEG-4") {
                            $generalFormat = "MP4";
                        }
                    }
                    if ($track->extra) {
                        $formats = [];
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
        
        // Checks
        foreach ($dbChecks as $checkId => $check) {
            foreach ($check->references as $reference) {
                if ($reference->specId == $specId) {
                    $references[] = '<a href="../Checks/' . $checkId . '">' . $check->description . '</a>';
                }
            }
        }

        return $references;
    }

    public static function getSpecElementChecks($specId, $elementId, $urlPrefix)
    {
        global $dbChecks;
        
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
                    if ($reference->specId == $specId && $reference->elementId == $elementId) {
                        $checks[] = $urlPrefix . $checkID . '">' . $check->description . '</a>';
                    }
                }
            }
        }
        
        return $checks;
    }

    public static function getSpecFieldChecks($specId, $elementId, $fieldId, $urlPrefix)
    {
        global $dbChecks;
        
        // Checks
        $urlPrefix = '<a href="' . $urlPrefix . 'Checks/';
        foreach ($dbChecks as $checkID => $check) {
            foreach ($check->references as $reference) {
                if ($reference->specId == $specId && $reference->elementId == $elementId && $reference->fieldId == $fieldId) {
                    $checks[] = $urlPrefix . $checkID . '">' . $check->description . '</a>';
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
