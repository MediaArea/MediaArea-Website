<?php

namespace MediaConchOnlineBundle\Lib\XslPolicy;

class XslPolicyGetRule extends XslPolicyBase
{
    public function getRule($id, $policyId)
    {
        $this->response = $this->mc->policyGetRule($this->user->getId(), $id, $policyId);
    }
}
