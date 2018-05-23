<?php

namespace MediaConchOnlineBundle\Lib\XslPolicy;

class XslPolicyGetPoliciesCount extends XslPolicyBase
{
    public function getPoliciesCount()
    {
        $this->response = $this->mc->policyGetPoliciesCount($this->user->getId());
    }

    public function getPoliciesCountByUser($userId)
    {
        $this->response = $this->mc->policyGetPoliciesCount($userId);
    }
}
