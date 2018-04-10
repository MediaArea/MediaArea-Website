<?php

namespace MediaConchOnlineBundle\Lib\XslPolicy;

class XslPolicyGetPolicies extends XslPolicyBase
{
    public function getPolicies(array $ids, $format = 'JSON')
    {
        $this->response = $this->mc->policyGetPolicies($this->user->getId(), $ids, $format);
    }
}
