<?php

namespace MediaBinBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\GoneHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MediaBinBundle\Entity\Bin;
use MediaBinBundle\Lib\File\File;
use MediaBinBundle\Lib\MediaInfoCLI;

/**
 * @Route("/MediaBin")
 * @Security("has_role('ROLE_BETA')").
 */
class DefaultController extends Controller
{
    /**
     * @Route("", name="mediabin_home")
     * @Template()
     */
    public function indexAction()
    {
        $itemsPerPage = 10;
        $binRepository = $this->getDoctrine()->getRepository(Bin::class);

        $user = $this->getUser();
        if (is_object($user) && $user instanceof UserInterface) {
            $userBin = $binRepository->getUserBin($user, 0, $itemsPerPage);
        }

        return [
            'latestsPublicBin' => $binRepository->getLatestsPublicBin(0, $itemsPerPage),
            'latestsPublicBinCount' => $binRepository->getLatestsPublicBin(0, $itemsPerPage)->count(),
            'userBin' => $userBin ?? null,
            'userBinCount' => isset($userBin) ? $userBin->count() : null,
            'itemsPerPage' => $itemsPerPage,
        ];
    }

    /**
     * @Route("/{hash}", requirements={"hash": "[a-zA-Z0-9]{8}"}, name="mediabin_show")
     * @Template()
     */
    public function showAction(Bin $bin, MediaInfoCLI $mediainfo, File $file)
    {
        // Check if MediaBin is expired
        if ($bin->hasExpired()) {
            // Owners can access to their MediaBin even if it has expired
            $user = $this->getUser();
            if (!is_object($user) || !$user instanceof UserInterface || $user != $bin->getUser()) {
                throw new GoneHttpException();
            }
        }

        // Load XML
        try {
            $xml = base64_encode($file->get($bin->getHash()));
        } catch (\Exception $e) {
            throw new ServiceUnavailableHttpException();
        }

        if (1 == $bin->getAnonymize()) {
            // Get anonymized MediaInfo report
            $mediainfo->getReportFromXML($file->getFileNameWithPath($bin->getHash()), 1, 1);
            $xml = $mediainfo->getOutput();
        }

        // Get MediaInfo report to display before javascript is loaded
        $mediainfo->getReportFromXML($file->getFileNameWithPath($bin->getHash()), $bin->getAnonymize());

        return ['bin' => $bin, 'xml' => $xml, 'report' => $mediainfo->getOutput()];
    }
}
