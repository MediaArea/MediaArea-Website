<?php

namespace MediaConchOnlineBundle\Lib\XslPolicy;

class XslPolicyFormValues extends XslPolicyBase
{
    public function getValues($trackType, $field, $value = null)
    {
        $this->value = $value;
        $this->response = $this->mc->valuesFromType($trackType, $field);
    }

    public function getResponseAsArray()
    {
        return [
            'values' => $this->getDefaultValues(),
            'error' => $this->response->getError(),
        ];
    }

    protected function getDefaultValues()
    {
        if (null !== $this->value) {
            $values = $this->response->getValues();
            if (is_array($values) && 1 <= count($values)) {
                if (!in_array($this->value, $values)) {
                    $values[] = $this->value;
                }
            } else {
                $values = [$this->value];
            }

            return $values;
        }

        return $this->response->getValues();
    }
}
