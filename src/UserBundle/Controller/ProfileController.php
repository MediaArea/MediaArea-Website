<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use PaymentBundle\Entity\Invoice;
use VoteBundle\Entity\Vote;
use VoteBundle\Entity\Feature;

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

        $userVotes = $this->getDoctrine()->getRepository(Vote::class)->getTotalVotesByUser($user);

        $userVotesFeatures = $this->getDoctrine()->getRepository(Feature::class)->getFeaturesVotedByUser($user);

        return $this->render('@FOSUser/Profile/show.html.twig', [
            'user' => $user,
            'language' => $language ?? null,
            'country' => $country ?? null,
            'invoices' => $invoices,
            'data' => [
                'id' => '',
                'date' => '',
                'amount' => '',
                'vat' => '',
                'total' => '',
                'product' => '',
                'country' => '',
                'currency' => '',
            ],
            'userVotes' => $userVotes,
            'userVotesFeatures' => $userVotesFeatures,
        ]);
    }
}
