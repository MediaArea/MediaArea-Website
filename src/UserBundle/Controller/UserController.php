<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use UserBundle\Form\Type\SettingsFormType;
use UserBundle\Form\Type\GuestRegisterFormType;
use PaymentBundle\Entity\Invoice;
use UserBundle\Lib\Quotas\Quotas;
use UserBundle\Lib\Settings\SettingsManager;
use VoteBundle\Entity\Vote;
use VoteBundle\Entity\Feature;

/**
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
class UserController extends Controller
{
    /**
     * @Route("/settings", name="user_settings")
     * @Template()
     */
    public function settingsAction(Request $request, SettingsManager $settings)
    {
        $form = $this->createForm(SettingsFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $settings->setDefaultPolicy($data['policy']);
            $settings->setDefaultDisplay($data['display']);
            $settings->setDefaultVerbosity($data['verbosity']);

            $this->addFlash('success', 'Settings successfully saved');

            return $this->redirectToRoute('user_settings');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/guest", name="user_guest_help")
     * @Template()
     */
    public function guestHelpAction()
    {
        return [];
    }

    /**
     * @Route("/guest/register", name="user_guest_register")
     */
    public function guestRegisterAction(Request $request, Quotas $quotas)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface || !$user->hasRole('ROLE_GUEST')) {
            throw new AccessDeniedException('You do not have access to this section.');
        }

        // Store referer
        if ('GET' == $request->getMethod() && $request->headers->get('referer') != $request->getUri()) {
            $this->get('session')->set('registerRedirect', $request->headers->get('referer'));
        }

        $form = $this->createForm(GuestRegisterFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEnabled(true);

            $this->addFlash('success', 'You have been registered successfully');

            if ($this->getParameter('fos_user.registration.confirmation.enabled')) {
                $this->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';

                // Keep guest user enable to avoid redirect to login page
                if (null === $user->getConfirmationToken()) {
                    $user->setConfirmationToken($this->get('fos_user.util.token_generator')->generateToken());
                }

                $this->get('fos_user.mailer')->sendConfirmationEmailMessage($user);
            } else {
                $route = 'fos_user_registration_confirmed';

                // Remove guest token cookie
                $request->attributes->set('remove_guest_cookie', true);

                // Switch role to basic
                $user->removeRole('ROLE_GUEST');
                $user->addRole('ROLE_BASIC');

                // Remove guest token in DB
                $token = $user->getGuestToken();
                $user->setGuestToken(null);
                $em = $this->getDoctrine()->getManager();
                $em->remove($token);

                // Set quotas for new user with mail activation disabled
                $quotas->resetQuotas();
            }

            // Update user
            $this->get('fos_user.user_manager')->updateUser($user);

            return $this->redirectToRoute($route);
        }

        return $this->render('@User/Registration/guest_register.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Show the user.
     *
     * @Route("/profile/")
     * @Template()
     */
    public function showProfileAction(Quotas $quotas)
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

        return [
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
            'userVotes' => $this->getDoctrine()->getRepository(Vote::class)->getTotalVotesByUser($user),
            'userVotesFeatures' => $this->getDoctrine()->getRepository(Feature::class)->getFeaturesVotedByUser($user),
            'quotas' => $quotas->getQuotasForProfile(),
        ];
    }
}
