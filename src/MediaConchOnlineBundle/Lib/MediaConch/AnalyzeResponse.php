<?php

namespace MediaConchOnlineBundle\Lib\MediaConch;

class AnalyzeResponse extends MediaConchServerAbstractResponse
{
    protected $analyze = [];

    public function getAnalyze()
    {
        return $this->analyze;
    }

    protected function parse($response)
    {
        if (is_array($response->ok) && 0 < count($response->ok)) {
            foreach ($response->ok as $analyze) {
                $this->analyze[$analyze->inId] = ['status' => true, 'transactionId' => $analyze->outId];
            }
        }

        if (is_array($response->nok) && 0 < count($response->nok)) {
            foreach ($response->nok as $analyze) {
                $this->analyze[$analyze->inId] = ['status' => false, 'transactionId' => $analyze->outId];
            }
        }
    }
}
