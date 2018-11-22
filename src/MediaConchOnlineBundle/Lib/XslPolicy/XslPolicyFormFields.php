<?php

namespace MediaConchOnlineBundle\Lib\XslPolicy;

use MediaConchOnlineBundle\Lib\MediaConch\MediaConchTrackTypes;
use MediaConchOnlineBundle\Lib\MediaConch\MediaConchTrackTypeFields;

class XslPolicyFormFields
{
    public static function getValidators()
    {
        return [
            'Is equal (==)' => 'is_equal',
            'Is not equal (!=)' => 'is_not_equal',
            'Is less than (<)' => 'is_less_than',
            'Is less or equal than (<=)' => 'is_less_or_equal_than',
            'Is greater than (>)' => 'is_greater_than',
            'Is greater or equal than (>=)' => 'is_greater_or_equal_than',
            'Exists' => 'exists',
            'Does not exist' => 'does_not_exist',
            'Contains string' => 'contains_string',
        ];
    }

    public static function getOperators()
    {
        return [
            'Exists' => 'exists',
            'Does not exist' => 'must not exist',
            'Is equal (=)' => '=',
            'Is not equal (!=)' => '!=',
            'Is less than (<)' => '<',
            'Is less or equal than (<=)' => '<=',
            'Is greater than (>)' => '>',
            'Is greater or equal than (>=)' => '>=',
            'Starts with' => 'starts with',
            'Does not start with' => 'must not start with',
        ];
    }

    public static function getTrackTypes()
    {
        $mcTrackTypes = new MediaConchTrackTypes();
        $mcTrackTypes->run();
        $mcTrackTypes = explode(',', $mcTrackTypes->getOutput());
        $trackTypes = [];

        foreach ($mcTrackTypes as $type) {
            $trackTypes[$type] = $type;
        }

        return $trackTypes;
    }

    public static function getFields($trackType, $xslField = null)
    {
        $fields = [];

        if ('' != $trackType) {
            $mcFields = new MediaConchTrackTypeFields();
            $mcFields->run($trackType);
            $mcFields = explode(',', $mcFields->getOutput());

            foreach ($mcFields as $field) {
                $fields[$field] = $field;
            }
        }

        if (null != $xslField) {
            if (!in_array($xslField, $fields)) {
                $fields[$xslField] = $xslField;
            }
        }

        return $fields;
    }
}
