<?php

namespace MediaBinBundle\Lib\File;

class LocalFile
{
    protected $path;

    public function __construct($conf)
    {
        $this->setPath($conf['path']);
    }

    public function save($binHash, $content)
    {
        // Create dir if not exists
        if (!file_exists($this->getPathForFile($binHash))) {
            if (!mkdir($this->getPathForFile($binHash), 0750, true)) {
                throw new \Exception('Unable to create local directory to store bin file');
            }
        }
        if (false === file_put_contents($this->getFileNameWithPath($binHash), $content)) {
            throw new \Exception('Unable to write bin file');
        }
    }

    public function delete($binHash)
    {
        if (file_exists($this->getFileNameWithPath($binHash))) {
            unlink($this->getFileNameWithPath($binHash));
        }
    }

    public function get($binHash)
    {
        if (file_exists($this->getFileNameWithPath($binHash))) {
            return file_get_contents($this->getFileNameWithPath($binHash));
        }

        return false;
    }

    public function getFileName($binHash)
    {
        return $binHash.'.xml';
    }

    public function getFileNameWithPath($binHash)
    {
        return $this->getPathForFile($binHash).$this->getFileName($binHash);
    }

    public function getPathForFile($binHash)
    {
        return $this->path.substr($binHash, 0, 1).'/'.substr($binHash, 1, 1).'/';
    }

    public function getPath()
    {
        return $this->path;
    }

    protected function setPath($path)
    {
        $this->path = rtrim($path, '/').'/';

        return $this;
    }
}
