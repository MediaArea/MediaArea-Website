<?php

namespace MediaConchOnlineBundle\Lib\Checker;

class CheckerFilename extends CheckerBase
{
    public function fileFromId($id)
    {
        $this->response = $this->mc->fileFromId($this->user->getId(), $id);
    }

    public function getResponseAsArray()
    {
        return ['file' => $this->response->getFile()];
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getFilename($full = false)
    {
        if ($full) {
            return $this->response->getFile();
        }

        return pathinfo($this->response->getFile(), PATHINFO_BASENAME);
    }
}
