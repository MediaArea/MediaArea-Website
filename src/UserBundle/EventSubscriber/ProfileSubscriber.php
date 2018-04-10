<?php

namespace UserBundle\EventSubscriber;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProfileSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::PROFILE_EDIT_INITIALIZE => 'onProfileEditInitialize',
        );
    }

    public function onProfileEditInitialize(GetResponseUserEvent $event)
    {
        // Guest user cannot edit their profile
        if ($event->getUser()->hasRole('ROLE_GUEST')) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
    }
}
