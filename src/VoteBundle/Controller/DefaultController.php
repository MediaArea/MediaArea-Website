<?php

namespace VoteBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use VoteBundle\Entity\Feature;
use VoteBundle\Entity\Vote;
use VoteBundle\Form\VoteType;
use VoteBundle\Model\FeatureInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/Vote", name="vote_list_features")
     * @Template()
     */
    public function indexAction()
    {
        $featureRepository = $this->getDoctrine()->getRepository(Feature::class);
        if (is_object($this->getUser()) && $this->getUser() instanceof UserInterface) {
            return [
                'features' => $featureRepository->getOpenFeaturesWithUserVotes($this->getUser()),
            ];
        }

        return ['features' => $featureRepository->getOpenFeatures()];
    }

    /**
     * @Route("/Vote/{slug}-{id}", requirements={"slug": "[a-zA-Z0-9\-]+", "id": "\d+"}, name="vote_show_feature")
     * @Template()
     */
    public function showAction($slug, Feature $feature, Request $request)
    {
        // Check slug
        if ($slug != $feature->getSlug()) {
            return $this->redirectToRoute('vote_show_feature', [
                'slug' => $feature->getSlug(),
                'id' => $feature->getId(),
            ], 301);
        }

        // Users cannot display closed features
        if (FeatureInterface::STATUS_CLOSE === $feature->getStatus()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, $this->get('translator')->trans('vote.feature.close'));
        }

        $user = $this->getUser();

        $userVotesFeature = 0;
        $voteMax = 0;
        if ($user) {
            $userVotesFeature = $this->getDoctrine()->getRepository(Vote::class)
                ->getTotalVotesByUserAndFeature($user, $feature);

            if ($userVotesFeature > $user->getVote()) {
                $voteMax = $userVotesFeature + $user->getVote();
            } else {
                $voteMax = $user->getVote();
            }
        }

        $form = $this->createForm(VoteType::class, null, [
            'data' => ['vote' => $userVotesFeature],
            'attr' => ['min' => 0, 'max' => $voteMax],
        ]);

        $form->handleRequest($request);
        if ('POST' === $request->getMethod() && $form->isSubmitted() && $form->isValid()) {
            return $this->featureFormHandler($feature, $user, $form->getData(), $userVotesFeature);
        }

        return [
            'feature' => $feature,
            'userVotesFeature' => $userVotesFeature,
            'form' => $form->createView(),
        ];
    }

    protected function featureFormHandler(FeatureInterface $feature, $user, $formDatas, $userVotesFeature)
    {
        $trans = $this->get('translator');
        if (FeatureInterface::STATUS_OPEN !== $feature->getStatus()) {
            return $this->redirectToFeatureWithFlash('danger', $trans->trans('vote.feature.vote.close'), $feature);
        }

        $points = $formDatas['vote'] - $userVotesFeature;

        if (0 == $points) {
            return $this->redirectToFeatureWithFlash(
                'info',
                $trans->trans('vote.feature.vote.same', ['%points%' => $userVotesFeature]),
                $feature
            );
        }

        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirectToFeatureWithFlash(
                'danger',
                $trans->trans('vote.feature.vote.login', ['%login%' => $this->generateUrl('fos_user_security_login')]),
                $feature
            );
        }

        // Check if user have enough voting points
        if ($user->getVote() < $points) {
            return $this->redirectToFeatureWithFlash('danger', $trans->trans('vote.feature.vote.low'), $feature);
        }

        // User cannot remove voting points not set
        if (($userVotesFeature + $points) < 0) {
            return $this->redirectToFeatureWithFlash('danger', $trans->trans('vote.feature.vote.remove'), $feature);
        }

        $em = $this->getDoctrine()->getManager();

        // Add vote
        $vote = new Vote();
        $vote->setUser($user)->setFeature($feature)->setPoints($points)->setDate(new \DateTime());
        $em->persist($vote);

        // Remove voting points to user
        $user->removeVote($points);
        $em->persist($user);

        // Add votes count to feature
        $feature->addVotesCountCache($points);
        $em->persist($feature);

        $em->flush();

        if (0 > $points) {
            return $this->redirectToFeatureWithFlash(
                'success',
                $trans->trans('vote.feature.vote.success.remove', ['%points%' => -$points]),
                $feature
            );
        }

        return $this->redirectToFeatureWithFlash(
            'success',
            $trans->trans('vote.feature.vote.success.add', ['%points%' => $points]),
            $feature
        );
    }

    protected function redirectToFeatureWithFlash($type, $message, FeatureInterface $feature)
    {
        $this->addFlash($type, $message);

        return $this->redirectToRoute('vote_show_feature', [
            'slug' => $feature->getSlug(),
            'id' => $feature->getId(),
        ], 302);
    }
}
