<?php

namespace MediaBinBundle\Lib\File;

use OpenStack\OpenStack;

class ExternalFile
{
    protected $conf;
    protected $enabled;
    protected $openstack;

    public function __construct($conf)
    {
        $this->setEnabled($conf['enabled']);
        if ($this->enabled) {
            $this->conf = $conf['openstack'];
        }
    }

    public function save($binHash, $content)
    {
        $file = [
            'name' => $binHash.'.xml',
            'content' => $content,
        ];

        try {
            $this->connect();
            $this->openstack->objectStoreV1()
                ->getContainer($this->conf['container'])
                ->createObject($file);
        } catch (\exception $e) {
            return false;
        }
    }

    public function delete($binHash)
    {
        try {
            $this->connect();
            $this->openstack->objectStoreV1()
                ->getContainer($this->conf['container'])
                ->getObject($binHash.'.xml')
                ->delete();
        } catch (\exception $e) {
            return false;
        }
    }

    public function get($binHash)
    {
        try {
            $this->connect();
            $stream = $this->openstack->objectStoreV1()
                ->getContainer($this->conf['container'])
                ->getObject($binHash.'.xml')
                ->download();

            return $stream->getContents();
        } catch (\exception $e) {
            return false;
        }
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    protected function setEnabled($enabled)
    {
        if (true === $enabled) {
            $this->enabled = true;
        } else {
            $this->enabled = false;
        }

        return $this;
    }

    /**
     * Connect to OpenStack.
     *
     * @return OpenStack
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function connect()
    {
        if ($this->openstack) {
            return;
        }

        $this->openstack = new OpenStack([
            'authUrl' => $this->conf['auth_url'],
            'region' => $this->conf['region'],
            'user' => [
                'name' => $this->conf['username'],
                'password' => $this->conf['password'],
                'domain' => ['name' => 'Default'],
            ],
            'scope' => ['project' => ['id' => $this->conf['tenant_id']]],
        ]);
    }
}
