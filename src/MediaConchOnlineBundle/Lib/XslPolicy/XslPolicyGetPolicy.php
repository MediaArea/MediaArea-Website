<?php

namespace MediaConchOnlineBundle\Lib\XslPolicy;

use MediaConchOnlineBundle\Lib\MediaConch\MediaConchServerException;

class XslPolicyGetPolicy extends XslPolicyBase
{
    public function getPolicy($id, $format = 'JSON')
    {
        $this->response = $this->mc->policyGetPolicy($this->user->getId(), $id, $format);
    }

    public function getPublicPolicy($id, $userId, $format = 'JSON')
    {
        $this->response = $this->mc->policyGetPolicy($userId, $id, $format, true);
    }
}
