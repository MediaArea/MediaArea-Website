<?php

namespace UserBundle\EventSubscriber;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\RememberMe\RememberMeServicesInterface;
use Doctrine\ORM\NoResultException;
use MediaConchOnlineBundle\Controller\PublicApiController;
use UserBundle\Controller\GuestControllerInterface;
use UserBundle\Entity\GuestToken;
use DeviceDetector\Parser\Bot as BotParser;
use FOS\UserBundle\Model\UserInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class GuestSubscriber implements EventSubscriberInterface
{
    protected $firewallName;
    protected $container;
    protected $rememberMeServices;

    public function __construct(
        $firewallName,
        ContainerInterface $container,
        RememberMeServicesInterface $rememberMeServices
    ) {
        $this->firewallName = $firewallName;
        $this->container = $container;
        $this->rememberMeServices = $rememberMeServices;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => 'guestAuthentication',
            KernelEvents::RESPONSE => 'rememberMeGuestCookie',
        );
    }

    public function guestAuthentication(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller) && !isset($controller[0])) {
            return;
        }
        $ctrl = $controller[0];

        // Public API user
        if ($ctrl instanceof PublicApiController) {
            $this->publicApiUser();
        } elseif (!$ctrl instanceof GuestControllerInterface) {
            return;
        }

        $user = $this->loginUser($event);

        // Check if user have at least ROLE_USER
        if (false === $user->hasRole('ROLE_USER')) {
            throw new AccessDeniedException();
        }
    }

    public function rememberMeGuestCookie(FilterResponseEvent $event)
    {
        // Check if remember_me attribute has been set and add cookie to response
        if (true == $event->getRequest()->attributes->get('remember_me_guest_cookie')) {
            // Force _remember_me value to yes
            $event->getRequest()->query->set('_remember_me', 'yes');

            // Set rememberme cookie by calling loginSuccess
            $this->rememberMeServices->loginSuccess(
                $event->getRequest(),
                $event->getResponse(),
                $this->container->get('security.token_storage')->getToken()
            );
        }

        // Check if guest cookie attribute has been set and add cookie to response
        if (null !== $cookie = $event->getRequest()->attributes->get('guest_cookie')) {
            $cookie = new Cookie('guest', $cookie, strtotime('now + 1 month'));
            $event->getResponse()->headers->setCookie($cookie);
        }

        // Check if guest cookie remove attribute has been set and remove cookie
        if (true == $event->getRequest()->attributes->get('remove_guest_cookie')) {
            $cookie = new Cookie('guest', null);
            $event->getResponse()->headers->setCookie($cookie);
        }
    }

    protected function createGuestUser($event)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        // Generate unique username
        do {
            $username = $this->generateRandomGuestUsername();
        } while (null !== $userManager->findUserByUsername($username));

        // Create user
        $user = $this->container->get('fos_user.util.user_manipulator')->create(
            $username,
            $this->container->get('fos_user.util.token_generator')->generateToken(),
            $username.'@mco',
            1,
            0
        );
        $user->setName(null);

        // Update last login date
        $user->setLastLogin(new \DateTime());

        // Add guest role
        $user->addRole('ROLE_GUEST');
        $userManager->updateUser($user);

        // Set token
        $token = $this->container->get('fos_user.util.token_generator')->generateToken();
        $guestToken = new GuestToken();
        $guestToken->setUser($user);
        $guestToken->setToken($token);
        $em = $this->container->get('doctrine.orm.entity_manager');
        $em->persist($guestToken);
        $em->flush();
        $event->getRequest()->attributes->set('guest_cookie', $username.':'.$token);

        // Set remember_me attribute to add cookie in response
        $event->getRequest()->attributes->set('remember_me_guest_cookie', true);

        return $user;
    }

    protected function publicApiUser()
    {
        $username = 'publicAPI';
        $userManager = $this->container->get('fos_user.user_manager');

        // Create user if not exists
        if (null === $user = $userManager->findUserByUsername($username)) {
            $user = $this->container->get('fos_user.util.user_manipulator')->create(
                $username,
                $this->container->get('fos_user.util.token_generator')->generateToken(),
                $username.'@mco',
                1,
                0
            );
        }

        // Log in user
        $this->container->get('fos_user.security.login_manager')->loginUser(
            $this->firewallName,
            $user
        );
    }

    protected function botUser()
    {
        // Bot user
        $username = 'guest';

        $userManager = $this->container->get('fos_user.user_manager');

        // Create user if not exists
        if (null === $user = $userManager->findUserByUsername($username)) {
            $user = $this->container->get('fos_user.util.user_manipulator')->create(
                $username,
                $this->container->get('fos_user.util.token_generator')->generateToken(),
                $username.'@mco',
                1,
                0
            );

            // Add guest role
            $user->addRole('ROLE_BOT');
            $userManager->updateUser($user);
        }

        return $user;
    }

    protected function guestUser($event)
    {
        // Read guest cookie
        if (false !== strpos($event->getRequest()->cookies->get('guest'), ':')) {
            list($username, $token) = explode(':', $event->getRequest()->cookies->get('guest'));
            if ('guest' == mb_substr($username, 0, 5) && preg_match('/^[a-z0-9]+$/', $username)) {
                // Get guest user token from DB
                $query = $this->container->get('doctrine.orm.entity_manager')->createQueryBuilder()->select('t.token')
                    ->from('UserBundle:User', 'u')
                    ->join('UserBundle:GuestToken', 't')
                    ->where('u.id = t.user')
                    ->andWhere('u.username = :user')
                    ->setParameter('user', $username)
                    ->setMaxResults(1)
                    ->getQuery();
                try {
                    if ($token == $query->getSingleScalarResult()) {
                        // Get user if token matches
                        $user = $this->container->get('fos_user.user_manager')->findUserByUsername($username);

                        // Set remember_me attribute to add cookie in response
                        $event->getRequest()->attributes->set('remember_me_guest_cookie', true);

                        return $user;
                    }
                } catch (NoResultException $e) {
                    // Do nothing guest user will be created after
                }
            }
        }

        return null;
    }

    protected function loginUser($event)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            unset($user);
            // Check bots
            $botParser = new BotParser();
            $botParser->discardDetails();
            $botParser->setUserAgent($event->getRequest()->headers->get('User-Agent'));

            if (true === $botParser->parse()) {
                // Bot user
                $user = $this->botUser();
            } elseif ($event->getRequest()->cookies->has('guest')) {
                // Read guest cookie
                $user = $this->guestUser($event);
            }

            // Create guest user if not done before
            if (!isset($user) || null === $user) {
                $user = $this->createGuestUser($event);
            }

            // Log in user
            $this->container->get('fos_user.security.login_manager')->loginUser(
                $this->firewallName,
                $user
            );
        }

        return $user;
    }

    protected function generateRandomGuestUsername()
    {
        if (false == preg_match('/([0-9]{6})/', uniqid(mt_rand(), true), $matches)) {
            return $this->generateRandomGuestUsername();
        }

        return 'guest'.$matches[1];
    }
}
