<?php

namespace MediaBinBundle\Lib;

use Symfony\Component\Process\Process;

class MediaInfoCLI
{
    protected $mediainfo = '/usr/bin/mediainfo';
    protected $success = false;
    protected $output;

    public function getOutput()
    {
        return $this->output;
    }

    public function getSuccess()
    {
        return $this->success;
    }

    protected function run($file, $anonymous = 0, $compress = 0)
    {
        $params = '--Input_Compressed=zlib ';
        if ($anonymous) {
            $params .= '--HideParameter=General_CompleteName ';
        }

        if ($compress) {
            $params .= '--Inform_Compress=zlib+base64 --Output=XML ';
        }

        $cmd = $this->mediainfo." $params $file";

        $process = new Process($cmd);

        $process->run();

        if ($process->isSuccessful()) {
            $this->success = true;
            $this->output = trim($process->getOutput());
        } else {
            $this->success = false;
        }

        return $this;
    }

    public function getReportFromXML($xmlFile, $anonymous = 0, $compress = 0)
    {
        $this->run($xmlFile, $anonymous, $compress);
    }
}
