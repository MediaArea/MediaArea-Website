<?php

namespace MediaBinBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use MediaBinBundle\Lib\File\File;

class BinSubscriber implements EventSubscriberInterface
{
    protected $binFile;

    public function __construct(File $binFile)
    {
        $this->binFile = $binFile;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::TERMINATE => 'create',
        ];
    }

    public function create(PostResponseEvent $event)
    {
        if (!$binHash = $event->getRequest()->attributes->get('mediabin.create')) {
            return;
        }

        $this->binFile->saveToExternal($binHash);
    }
}
