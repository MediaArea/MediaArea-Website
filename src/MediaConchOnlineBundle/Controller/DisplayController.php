<?php

namespace MediaConchOnlineBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use MediaConchOnlineBundle\Entity\DisplayFile;
use MediaConchOnlineBundle\Form\Type\DisplayImportFormType;
use UserBundle\Lib\Quotas\Quotas;

/**
 * @Route("/MediaConchOnline/display/")
 */
class DisplayController extends BaseController
{
    /**
     * @Route("", name="mco_display")
     * @Template()
     */
    public function displayAction(Request $request, Quotas $quotas)
    {
        $displayList = $this->getDoctrine()
            ->getRepository('MediaConchOnlineBundle:DisplayFile')
            ->findByUser($this->getUser());

        $displaySystemList = $this->getDoctrine()
            ->getRepository('MediaConchOnlineBundle:DisplayFile')
            ->findByUser(null);

        if ($quotas->hasPolicyCreationRights()) {
            $display = new DisplayFile();
            $importDisplayForm = $this->createForm(DisplayImportFormType::class, $display);
            $importDisplayForm->handleRequest($request);
            if ($importDisplayForm->isSubmitted() && $importDisplayForm->isValid()) {
                $em = $this->getDoctrine()->getManager();

                // Set user at the creation of the policy
                if (null === $display->getUser()) {
                    $display->setUser($this->getUser());
                }

                $em->persist($display);
                $em->flush();

                $this->addFlashBag('success', 'Display successfully added');

                return $this->redirectToRoute('mco_display');
            }
        }

        return [
            'importDisplayForm' => isset($importDisplayForm) ? $importDisplayForm->createView() : false,
             'displayList' => $displayList,
             'displaySystemList' => $displaySystemList,
        ];
    }

    /**
     * @Route("delete/{id}", requirements={"id": "\d+"}, name="mco_display_delete")
     * @Method("GET")
     */
    public function displayDeleteAction($id)
    {
        $policy = $this->getDoctrine()
            ->getRepository('MediaConchOnlineBundle:DisplayFile')
            ->findOneBy(['id' => $id, 'user' => $this->getUser()]);

        if (!$policy) {
            $this->addFlashBag('danger', 'Display not found');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($policy);
            $em->flush();

            $this->addFlashBag('success', 'Display successfully removed');
        }

        return $this->redirectToRoute('mco_display');
    }

    /**
     * @Route("export/{id}", requirements={"id": "\d+"}, name="mco_display_export")
     * @Method("GET")
     */
    public function displayExportAction($id)
    {
        $policy = $this->getDoctrine()
            ->getRepository('MediaConchOnlineBundle:DisplayFile')
            ->findOneBy(['id' => $id, 'user' => $this->getUser()]);

        if (!$policy) {
            $this->addFlashBag('danger', 'Display not found');

            return $this->redirectToRoute('mco_display');
        }

        $handler = $this->get('vich_uploader.download_handler');

        return $handler->downloadObject($policy, 'displayFile');
    }

    /**
     * @Route("system/export/{id}", requirements={"id": "\d+"}, name="mco_display_systemexport")
     * @Method("GET")
     */
    public function displaySystemExportAction($id)
    {
        $policy = $this->getDoctrine()
            ->getRepository('MediaConchOnlineBundle:DisplayFile')
            ->findOneBy(['id' => $id, 'user' => null]);

        if (!$policy) {
            $this->addFlashBag('danger', 'Display not found');

            return $this->redirectToRoute('mco_display');
        }

        $handler = $this->get('vich_uploader.download_handler');

        return $handler->downloadObject($policy, 'displayFile');
    }
}
