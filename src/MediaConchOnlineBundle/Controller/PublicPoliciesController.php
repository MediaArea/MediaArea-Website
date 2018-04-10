<?php

namespace MediaConchOnlineBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use MediaConchOnlineBundle\Lib\MediaConch\InitInstanceId;
use MediaConchOnlineBundle\Lib\MediaConch\MediaConchServerException;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyDuplicate;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyEditVisibility;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyExport;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyGetPolicyName;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicySave;
use UserBundle\Lib\Quotas\Quotas;

/**
 * @Route("/MediaConchOnline/publicPolicies")
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PublicPoliciesController extends BaseController
{
    /**
     * Public policies page.
     *
     * @Route("", name="mco_policy_public")
     * @Template()
     */
    public function listAction(InitInstanceId $init)
    {
        // Init MediaConch-Server-ID
        $init->init();

        return [];
    }

    /**
     * Export XML of a policy.
     *
     * @param int id policy ID of the policy to export
     * @param int userId user ID of the policy to export
     *
     * @return XML
     *
     * @Route("/export/{id}/{userId}", requirements={"id": "\d+", "userId": "\d+"}, name="mco_policy_public_export")
     * @Method("GET")
     */
    public function policyExportAction($id, $userId, XslPolicyExport $policyExport, XslPolicyGetPolicyName $policyName)
    {
        try {
            // Get policy XML
            $policyExport->publicExport($id, $userId);

            // Get policy name
            $policyName->getPublicPolicyName($id, $userId);
            $policyName = $policyName->getResponse()->getName();

            // Prepare response
            $response = new Response($policyExport->getPolicyXml());
            $disposition = $this->downloadFileDisposition($response, $policyName.'.xml');

            $response->headers->set('Content-Type', 'text/xml');
            $response->headers->set('Content-Disposition', $disposition);
            $response->headers->set('Content-length', strlen($policyExport->getPolicyXml()));

            return $response;
        } catch (MediaConchServerException $e) {
            throw new ServiceUnavailableHttpException();
        }
    }

    /**
     * Import a policy.
     *
     * @param int id policy ID of the policy to import
     * @param int userId user ID of the policy to import
     *
     * @return json
     *              {"policyId":ID}
     *
     * @Route("/import/{id}/{userId}", requirements={"id": "\d+", "userId": "\d+"}, name="mco_policy_public_import")
     * @Method("GET")
     */
    public function policyImportAction(
        $id,
        $userId,
        Request $request,
        Quotas $quotas,
        XslPolicyDuplicate $policyDuplicate,
        XslPolicyEditVisibility $policyEditVisibility,
        XslPolicySave $policySave
    ) {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        // Check quota only if policy is duplicated on the top level
        if (!$quotas->hasPolicyCreationRights()) {
            return new JsonResponse([
                'message' => 'Quota exceeded',
                'quota' => $this->renderView('MediaConchOnlineBundle:Default:quotaExceeded.html.twig'),
            ], 400);
        }

        try {
            // Duplicate policy
            $policyDuplicate->publicDuplicate($id, $userId);

            // Edit policy visibility
            $policyEditVisibility->editVisibility($policyDuplicate->getCreatedId(), 0);

            // Save policy
            $policySave->save($policyDuplicate->getCreatedId());

            return new JsonResponse(['policyId' => $policyDuplicate->getCreatedId()]);
        } catch (MediaConchServerException $e) {
            throw new ServiceUnavailableHttpException();
        }
    }
}
