<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use PaymentBundle\Entity\Invoice;

class ProfileController extends BaseController
{
    /**
     * Show the user.
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if ($user->getLanguage()) {
            $language = Intl::getLanguageBundle()->getLanguageName($user->getLanguage());
        }

        if ($user->getCountry()) {
            $country = Intl::getRegionBundle()->getCountryName($user->getCountry());
        }

        $invoices = $this->getDoctrine()
            ->getRepository(Invoice::class)
            ->findBy(['user' => $this->getUser()], ['date' => 'DESC']);

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
            'language' => $language ?? null,
            'country' => $country ?? null,
            'invoices' => $invoices,
        ));
    }
}
