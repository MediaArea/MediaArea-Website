<?php

namespace MediaBinBundle\Lib\File;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class File
{
    protected $externalFile;
    protected $localFile;
    protected $request;
    protected $mailer;
    protected $logger;

    public function __construct(
        ExternalFile $externalFile,
        LocalFile $localFile,
        RequestStack $requestStack,
        \Swift_Mailer $mailer,
        LoggerInterface $logger
    ) {
        $this->externalFile = $externalFile;
        $this->localFile = $localFile;
        $this->request = $requestStack->getCurrentRequest();
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function save($binHash, $content)
    {
        $this->localFile->save($binHash, $content);

        if ($this->externalFile->isEnabled()) {
            $this->request->attributes->set('mediabin.create', $binHash);
        }
    }

    public function saveToExternal($binHash)
    {
        if ($this->externalFile->isEnabled()) {
            if (false === $this->externalFile->save($binHash, $this->localFile->get($binHash))) {
                // Log error
                $this->logger->error('Unable to store XML to external storage', ['MediaBin hash' => $binHash]);
                // Send mail
                $message = (new \Swift_Message())
                    ->setSubject('[MediaBin] Unable to store XML to external storage')
                    ->setFrom('info@mediaarea.net')
                    ->setTo('guillaume@mediaarea.net')
                    ->setBody(
                        sprintf(
                            "Unable to store XML to external storage\nMediaBin hash: %s\nServer: %s",
                            $binHash,
                            gethostname()
                        ),
                        'text/plain'
                    );
                $this->mailer->send($message);
            }
        }
    }

    public function delete($binHash)
    {
        if ($this->externalFile->isEnabled()) {
            $this->externalFile->delete($binHash);
        }

        $this->localFile->delete($binHash);
    }

    public function get($binHash)
    {
        if (false === $xml = $this->localFile->get($binHash)) {
            if ($this->externalFile->isEnabled()) {
                $xml = $this->externalFile->get($binHash);
                if (false === $xml) {
                    throw new \Exception('Unable to retrieve the file');
                }
                $this->localFile->save($binHash, $xml);
            } else {
                throw new \Exception('File not found');
            }
        }

        return $xml;
    }

    public function isExternalEnabled()
    {
        return $this->externalFile->isEnabled();
    }

    public function getFileNameWithPath($binHash)
    {
        return $this->localFile->getFileNameWithPath($binHash);
    }

    public function getPath()
    {
        return $this->localFile->getPath();
    }
}
