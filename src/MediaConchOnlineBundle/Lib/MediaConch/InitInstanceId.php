<?php

namespace MediaConchOnlineBundle\Lib\MediaConch;

use MediaConchOnlineBundle\Lib\Checker\CheckerMediaInfoOutputList;

class InitInstanceId
{
    protected $command;

    public function __construct(CheckerMediaInfoOutputList $list)
    {
        $this->command = $list;
    }

    /**
     * Init the InstanceId
     * Use MediaInfoOutputList until MC-server have a dedicated API.
     */
    public function init()
    {
        try {
            $this->command->getList();
        } catch (MediaConchServerException $e) {
        }
    }
}
