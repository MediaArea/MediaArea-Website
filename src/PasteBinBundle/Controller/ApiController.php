<?php

namespace PasteBinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use PasteBinBundle\Entity\Paste;

/**
 * @Route("/api/v1")
 * @Security("has_role('ROLE_BETA')")
 */
class ApiController extends Controller
{
    /**
     * @Route("/p", name="pastebin_api_new")
     * @Method({"POST"})
     */
    public function newAction(Request $request)
    {
        // Get the XML
        $xml = $request->request->get('xml');
        // Get the title
        $title = $request->request->get('title');
        // Get the paste type
        //$type = $request->request->get('type');
        // Get the expiration date
        //$expiration = $request->request->get('expiration');

        $paste = new Paste();
        $paste
            ->setUser($this->getUser())
            ->setTitle($title)
            ->setType(1)
            ->setExpiration(new \DateTime())
            ->setDate(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($paste);
        $em->flush();

        // Add missing XML headers
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<MediaInfo
    xmlns="https://mediaarea.net/mediainfo"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="https://mediaarea.net/mediainfo https://mediaarea.net/mediainfo/mediainfo_2_0.xsd"
    version="2.0">
<creatingLibrary version="17.10" url="https://mediaarea.net/MediaInfo">MediaInfoLib</creatingLibrary>'.
        $xml
        .'</MediaInfo>';

        file_put_contents('/dev/shm/'.$paste->getId().'.xml', $xml);

        return new JsonResponse(['url' => $this->generateUrl(
            'pastebin_show',
            ['id' => $paste->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        )]);
    }
}
