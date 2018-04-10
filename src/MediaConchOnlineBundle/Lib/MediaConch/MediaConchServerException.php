<?php

namespace MediaConchOnlineBundle\Lib\MediaConch;

use Symfony\Component\HttpKernel\Exception\HttpException;

class MediaConchServerException extends HttpException
{
    protected $statusCode;

    public function __construct($message = null, $statusCode = 400, \Exception $previous = null, $code = 0)
    {
        $this->statusCode = $statusCode;

        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
