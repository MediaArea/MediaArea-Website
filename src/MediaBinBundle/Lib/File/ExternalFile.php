<?php

namespace MediaBinBundle\Lib\File;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack as GuzzleHandlerStack;
use OpenStack\OpenStack;
use OpenStack\Identity\v2\Service as OpenStackService;
use OpenStack\Common\Transport\Utils as OpenStackUtils;

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
            'username' => $this->conf['username'],
            'password' => $this->conf['password'],
            'tenantId' => $this->conf['tenant_id'],
            'identityService' => OpenStackService::factory(
                new GuzzleClient([
                    'base_uri' => OpenStackUtils::normalizeUrl($this->conf['auth_url']),
                    'handler' => GuzzleHandlerStack::create(),
                ])
            ),
        ]);
    }
}
