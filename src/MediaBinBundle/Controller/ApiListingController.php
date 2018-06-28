<?php

namespace MediaBinBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MediaBinBundle\Entity\Bin;

/**
 * @Route("/api/v1/MediaBin/list")
 */
class ApiListingController extends Controller
{
    /**
     * @Route("/byUser", name="mediabin_api_listing_user")
     * @Method({"GET"})
     */
    public function byUserAction(Request $request, TranslatorInterface $translator)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return new JsonResponse(['error' => 'User not logged'], 401);
        }

        (int) $start = $request->query->get('start', 0);
        if (0 > $start) {
            return new JsonResponse(['error' => 'Start parameter should be an integer >= 0'], 400);
        }

        (int) $limit = $request->query->get('limit', 5);
        if (1 > $limit) {
            return new JsonResponse(['error' => 'Limit parameter should be an integer >= 1'], 400);
        }

        $binRepository = $this->getDoctrine()->getRepository(Bin::class);

        $list = [];
        $defaultBinTitle = $translator->trans('mediabin.create.title.placeholder');
        foreach ($binRepository->getUserBin($user, $start, $limit) as $bin) {
            $list[] = [
                'title' => $bin->getTitleListing($defaultBinTitle),
                 'hash' => $bin->getHash(),
             ];
        }

        return new JsonResponse(['list' => $list]);
    }

    /**
     * @Route("/latestsPublic", name="mediabin_api_listing_latests_public")
     * @Method({"GET"})
     */
    public function latestsPublicAction(Request $request, TranslatorInterface $translator)
    {
        (int) $start = $request->query->get('start', 0);
        if (0 > $start) {
            return new JsonResponse(['error' => 'Start parameter should be an integer >= 0'], 400);
        }
        if (100 <= $start) {
            return new JsonResponse(['error' => 'Start parameter should be an integer < 100'], 400);
        }

        (int) $limit = $request->query->get('limit', 5);
        if (1 > $limit) {
            return new JsonResponse(['error' => 'Limit parameter should be an integer >= 1'], 400);
        }

        $binRepository = $this->getDoctrine()->getRepository(Bin::class);

        $list = [];
        $defaultBinTitle = $translator->trans('mediabin.create.title.placeholder');
        foreach ($binRepository->getLatestsPublicBin($start, $limit) as $bin) {
            $list[] = [
                'title' => '' == $bin->getTitle() ? $defaultBinTitle : $bin->getTitle(),
                 'hash' => $bin->getHash(),
             ];
        }

        return new JsonResponse(['list' => $list]);
    }
}
