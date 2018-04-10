<?php

namespace MediaConchOnlineBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\Finder\Finder;
use MediaConchOnlineBundle\Form\Type\CheckerOnlineFormType;
use MediaConchOnlineBundle\Form\Type\CheckerRepositoryFormType;
use MediaConchOnlineBundle\Form\Type\CheckerUploadFormType;
use MediaConchOnlineBundle\Lib\Checker\CheckerAnalyze;
use MediaConchOnlineBundle\Lib\Checker\CheckerFilename;
use MediaConchOnlineBundle\Lib\Checker\CheckerMediaInfoOutputList;
use MediaConchOnlineBundle\Lib\Checker\CheckerReport;
use MediaConchOnlineBundle\Lib\Checker\CheckerStatus;
use MediaConchOnlineBundle\Lib\Checker\CheckerValidate;
use MediaConchOnlineBundle\Lib\MediaConch\InitInstanceId;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyFromFile;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyGetPolicy;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicySave;
use MediaConchOnlineBundle\Lib\MediaConch\MediaConchServerException;
use UserBundle\Lib\Quotas\Quotas;
use UserBundle\Lib\Settings\SettingsManager;

/**
 * @Route("/MediaConchOnline/checker")
 *
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CheckerController extends BaseController
{
    /**
     * @Route("", name="mco_checker")
     * @Template()
     */
    public function checkerAction(Quotas $quotas, InitInstanceId $init)
    {
        // Init MediaConch-Server-ID
        $init->init();

        if ($quotas->hasUploadsRights()) {
            $formUpload = $this->createForm(CheckerUploadFormType::class);
        }

        if ($quotas->hasUrlsRights()) {
            $formOnline = $this->createForm(CheckerOnlineFormType::class);
        }

        if (null != $this->getParameter('mco_check_folder') && file_exists($this->getParameter('mco_check_folder'))) {
            if ($quotas->hasPolicyChecksRights()) {
                $formRepository = $this->createForm(CheckerRepositoryFormType::class);
            }
        }

        return [
            'formUpload' => isset($formUpload) ? $formUpload->createView() : false,
            'formOnline' => isset($formOnline) ? $formOnline->createView() : false,
            'formRepository' => isset($formRepository) ? $formRepository->createView() : false,
            'repositoryEnable' => isset($formRepository),
        ];
    }

    /**
     * @Route("/status", name="mco_checker_status")
     */
    public function checkerStatusAction(Request $request, CheckerStatus $status)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        // Get the list of IDs
        $ids = $request->request->get('ids');

        if (is_array($ids) && count($ids) > 0) {
            try {
                $status->getStatus($ids);

                return new JsonResponse(['status' => $status->getResponse()]);
            } catch (MediaConchServerException $e) {
                return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
            }
        }

        return new JsonResponse(['message' => 'Error'], 400);
    }

    /**
     * @Route("/reportStatus/{id}/{reportType}", requirements={"id": "\d+"}, name="mco_checker_report_status")
     */
    public function checkerReportStatusAction($id, $reportType, Request $request, CheckerValidate $validate)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        try {
            $validate->validate($id, $reportType);

            return new JsonResponse($validate->getResponseAsArray());
        } catch (MediaConchServerException $e) {
            return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
        }
    }

    /**
     * @Route("/policyStatus/{id}", requirements={"id": "\d+"}, name="mco_checker_policy_status")
     */
    public function checkerPolicyStatusAction($id, Request $request, CheckerValidate $validate)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        try {
            $validate->validate($id, 1, $request->query->get('policy'));

            return new JsonResponse($validate->getResponseAsArray());
        } catch (MediaConchServerException $e) {
            return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
        }
    }

    /**
     * @Route("/reportStatusMulti", name="mco_checker_report_status_multi")
     */
    public function statusReportsMultiAction(Request $request, CheckerValidate $validate)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        // Reports list
        $reports = $request->request->get('reports');
        if (is_array($reports) && count($reports) > 0) {
            try {
                $response = [];
                foreach ($reports as $report) {
                    // Implementation report
                    $validate->validate($report['id'], $report['tool']);
                    $response[$report['id']] = ['implemReport' => $validate->getResponseAsArray()];

                    // Policy report
                    if (isset($report['policyId'])) {
                        $validate->validate($report['id'], 1, $report['policyId']);
                        $response[$report['id']]['policyReport'] = $validate->getResponseAsArray();
                    }
                }

                return new JsonResponse($response);
            } catch (MediaConchServerException $e) {
                return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
            }
        }

        return new JsonResponse(['message' => 'Error'], 400);
    }

    /**
     * @Route("/report/{id}/{reportType}/{displayName}", requirements={"id": "\d+"}, name="mco_checker_report")
     */
    public function checkerReportAction(
        $id,
        $reportType,
        $displayName,
        Request $request,
        CheckerReport $report,
        CheckerFilename $file
    ) {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        $displayFile = null;
        if (ctype_digit($request->query->get('display'))) {
            $display = $this->getDoctrine()
                ->getRepository('MediaConchOnlineBundle:DisplayFile')
                ->findOneByUserOrSystem($request->query->get('display'), $this->getUser());
            if ($display) {
                $helper = $this->get('vich_uploader.storage');
                $displayFile = $helper->resolvePath($display, 'displayFile');
            }
        }

        try {
            $file->fileFromId($id);

            $report->report($id, $reportType, $displayName, $displayFile, $request->query->get('policy'), $request->query->get('verbosity'));

            $report->setFullPath(false, $file->getFilename(true));

            if (('mi' == $reportType || 'mt' == $reportType) && 'jstree' == $displayName) {
                return new Response($report->getReport());
            }

            return new JsonResponse($report->getResponseAsArray());
        } catch (MediaConchServerException $e) {
            return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
        }
    }

    /**
     * @Route("/createPolicy/{id}", requirements={"id": "\d+"}, name="mco_checker_create_policy")
     */
    public function checkerCreatePolicyAction(
        $id,
        Request $request,
        XslPolicyFromFile $policyFromFile,
        XslPolicyGetPolicy $policy,
        XslPolicySave $policySave
    ) {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        try {
            $policyFromFile->getPolicy($id);
            $policySave->save($policyFromFile->getCreatedId());
            $policy->getPolicy($policyFromFile->getCreatedId());
            $policy->getResponse()->getPolicy();
            $policy = $policy->getResponse()->getPolicy();

            return new JsonResponse(['result' => true, 'policyId' => $policy->id, 'policyName' => $policy->name]);
        } catch (MediaConchServerException $e) {
            return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
        }
    }

    /**
     * @Route(
     *     "/downloadReport/{id}/{reportType}/{displayName}",
     *     requirements={"id": "\d+"},
     *     name="mco_checker_report_download"
     * )
     */
    public function checkerDownloadReportAction(
        $id,
        $reportType,
        $displayName,
        Request $request,
        CheckerReport $report,
        CheckerFilename $file
    ) {
        if ($this->has('profiler')) {
            $this->get('profiler')->disable();
        }

        $displayFile = null;
        if (ctype_digit($request->query->get('display'))) {
            $display = $this->getDoctrine()
                ->getRepository('MediaConchOnlineBundle:DisplayFile')
                ->findOneByUserOrSystem($request->query->get('display'), $this->getUser());
            if ($display) {
                $helper = $this->get('vich_uploader.storage');
                $displayFile = $helper->resolvePath($display, 'displayFile');
            }
        }

        try {
            $file->fileFromId($id);

            if ($request->query->get('miFormat')) {
                $displayName = null;
            }

            $report->report($id, $reportType, $displayName, $displayFile, $request->query->get('policy'), $request->query->get('verbosity'), $request->query->get('miFormat'));

            $report->setFullPath(false, $file->getFilename(true));
            $response = new Response($report->getReport());
            $disposition = $this->downloadFileDisposition($response, $file->getFilename().'_'.$report->getDownloadReportName().'.'.$report->getDownloadReportExtension());

            $response->headers->set('Content-Type', $report->getDownloadReportMimeType());
            $response->headers->set('Content-Disposition', $disposition);
            $response->headers->set('Content-length', strlen($report->getReport()));

            return $response;
        } catch (MediaConchServerException $e) {
            throw new ServiceUnavailableHttpException();
        }
    }

    /**
     * @Route("/ajaxForm", name="mco_checker_ajaxform")
     */
    public function checkerAjaxFormAction(
        Request $request,
        Quotas $quotas,
        SettingsManager $settings,
        CheckerAnalyze $checks
    ) {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        $formUpload = $this->createForm(CheckerUploadFormType::class);
        $formUpload->handleRequest($request);
        if ($formUpload->isSubmitted()) {
            return $this->checkerAjaxFormUpload($formUpload, $quotas, $settings, $checks);
        }

        $formOnline = $this->createForm(CheckerOnlineFormType::class);
        $formOnline->handleRequest($request);

        if ($formOnline->isSubmitted()) {
            return $this->checkerAjaxFormOnline($formOnline, $quotas, $settings, $checks);
        }

        if (null != $this->getParameter('mco_check_folder') && file_exists($this->getParameter('mco_check_folder'))) {
            $formRepository = $this->createForm(CheckerRepositoryFormType::class);
            $formRepository->handleRequest($request);

            if ($formRepository->isSubmitted()) {
                return $this->checkerAjaxFormRepository($formRepository, $quotas, $settings, $checks);
            }
        }

        return new JsonResponse(['message' => 'No form selected'], 400);
    }

    protected function checkerAjaxFormUpload(
        $formUpload,
        Quotas $quotas,
        SettingsManager $settings,
        CheckerAnalyze $checks
    ) {
        if ($quotas->hasUploadsRights()) {
            if ($formUpload->isValid()) {
                $data = $formUpload->getData();

                $settings->setLastUsedPolicy($data['policy']);
                $settings->setLastUsedDisplay($data['display']);
                $settings->setLastUsedVerbosity($data['verbosity']);

                if ($data['file']->isValid()) {
                    $path = $this->getParameter('kernel.project_dir').'/files/upload/'.$this->getUser()->getId();
                    $filename = $data['file']->getClientOriginalName();
                    $fileMd5 = md5(file_get_contents($data['file']->getRealPath()));

                    if (file_exists($path.'/'.$fileMd5.'/'.$filename)) {
                        $file = new File($path.'/'.$fileMd5.'/'.$filename);
                    } else {
                        $file = $data['file']->move($path.'/'.$fileMd5, $filename);
                    }

                    try {
                        $checks->analyse([$file->getRealPath()]);

                        $quotas->hitUploads();

                        return new JsonResponse($checks->getResponseAsArray(), 200);
                    } catch (MediaConchServerException $e) {
                        return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
                    }
                }
            } else {
                return new JsonResponse(['message' => $formUpload->getErrors(true)->current()->getMessage()], 400);
            }
        } else {
            return new JsonResponse([
                'message' => 'Quota exceeded',
                'quota' => $this->renderView('MediaConchOnlineBundle:Default:quotaExceeded.html.twig'),
            ], 400);
        }

        return new JsonResponse(['message' => 'Error'], 400);
    }

    protected function checkerAjaxFormOnline(
        $formOnline,
        Quotas $quotas,
        SettingsManager $settings,
        CheckerAnalyze $checks
    ) {
        if ($quotas->hasUrlsRights()) {
            if ($formOnline->isValid()) {
                $data = $formOnline->getData();

                $settings->setLastUsedPolicy($data['policy']);
                $settings->setLastUsedDisplay($data['display']);
                $settings->setLastUsedVerbosity($data['verbosity']);

                try {
                    $checks->setFullPath(true);
                    $checks->analyse([str_replace(' ', '%20', $data['file'])]);

                    $quotas->hitUrls();

                    return new JsonResponse($checks->getResponseAsArray(), 200);
                } catch (MediaConchServerException $e) {
                    return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
                }
            }
        } else {
            return new JsonResponse([
                'message' => 'Quota exceeded',
                'quota' => $this->renderView('MediaConchOnlineBundle:Default:quotaExceeded.html.twig'),
            ], 400);
        }

        return new JsonResponse(['message' => 'Error'], 400);
    }

    protected function checkerAjaxFormRepository(
        $formRepository,
        Quotas $quotas,
        SettingsManager $settings,
        CheckerAnalyze $checks
    ) {
        if ($quotas->hasPolicyChecksRights()) {
            if ($formRepository->isValid()) {
                $data = $formRepository->getData();

                $settings->setLastUsedPolicy($data['policy']);
                $settings->setLastUsedDisplay($data['display']);
                $settings->setLastUsedVerbosity($data['verbosity']);

                try {
                    $finder = new Finder();
                    $finder->files()->in($this->getParameter('mco_check_folder'));
                    $files = [];
                    foreach ($finder as $file) {
                        $files[] = $file->getPathname();
                    }

                    $checks->analyse($files);

                    $quotas->hitPolicyChecks(count($finder));

                    return new JsonResponse($checks->getResponseAsArray(), 200);
                } catch (MediaConchServerException $e) {
                    return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
                }
            }
        } else {
            return new JsonResponse([
                'message' => 'Quota exceeded',
                'quota' => $this->renderView('MediaConchOnlineBundle:Default:quotaExceeded.html.twig'),
            ], 400);
        }

        return new JsonResponse(['message' => 'Error'], 400);
    }

    /**
     * @Route("/forceAnalyze/{id}", requirements={"id": "\d+"}, name="mco_checker_force_analyze")
     */
    public function checkerForceAnalyzeAction($id, Request $request, CheckerFilename $file, CheckerAnalyze $checks)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        try {
            // Get the filename
            $file->fileFromId($id);

            // Force analyze
            $checks->analyse([$file->getFilename(true)], true);
            $response = $checks->getResponseAsArray();

            return new JsonResponse($response);
        } catch (MediaConchServerException $e) {
            return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
        }
    }

    /**
     * @Route("/mediaInfoOutputList", name="mco_checker_mediainfo_outputlist")
     */
    public function checkerMediaInfoOutputListAction(Request $request, CheckerMediaInfoOutputList $list)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        try {
            // Get the list
            $list->getList();

            return new JsonResponse($list->getResponseAsArray());
        } catch (MediaConchServerException $e) {
            return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
        }
    }
}
