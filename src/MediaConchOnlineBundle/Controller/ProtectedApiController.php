<?php

namespace MediaConchOnlineBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use MediaConchOnlineBundle\Lib\MediaConch\InitInstanceId;
use MediaConchOnlineBundle\Lib\MediaConch\MediaConchServerException;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyEditVisibility;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyExport;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyGetPolicies;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyGetPublicPolicies;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyImport;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicySave;

/**
 * @Route("/MediaConchOnline/api/protected/v1")
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ProtectedApiController extends Controller
{
    /**
     * Import a policy to the oublic policies list.
     *
     * @return json
     * @Route("/publicpolicies/import")
     * @Route("/policies/import")
     * @Method({"POST"})
     */
    public function importPolicyAction(
        Request $request,
        XslPolicyImport $policyImport,
        XslPolicyEditVisibility $policyEditVisibility,
        XslPolicySave $policySave
    ) {
        // Get the policy XML
        $xml = $request->request->get('xml');

        // Get the policy visibility
        $visibility = $request->request->get('visibility', 'public');

        if (null === $xml || '' == $xml) {
            return new JsonResponse(['message' => 'The policy XML is empty'], 400);
        }

        try {
            // Import policy
            $policyImport->import($xml);

            if ('public' == $visibility) {
                // Make policy public
                $policyEditVisibility->editVisibility($policyImport->getCreatedId(), true);
            } else {
                // Make policy private
                $policyEditVisibility->editVisibility($policyImport->getCreatedId(), false);
            }

            // Save policy
            $policySave->save($policyImport->getCreatedId());
        } catch (MediaConchServerException $e) {
            return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
        }

        return new JsonResponse(['message' => 'Success']);
    }

    /**
     * Public policies list.
     *
     * @return json
     * @Route("/publicpolicies/list")
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function publicPoliciesListAction(InitInstanceId $init, XslPolicyGetPublicPolicies $policyList)
    {
        // Init MediaConch-Server-ID
        $init->init();

        $list = [];

        try {
            // Get public policies from server
            $policyList->getPublicPolicies();
            $policyList = $policyList->getResponse()->getPolicies();

            if (0 < count($policyList)) {
                // Fetch user list
                $userList = [];
                foreach ($policyList as $policy) {
                    if (!in_array($policy->user, $userList)) {
                        $userList[] = $policy->user;
                    }
                }

                // Fetch users
                $query = $this->getDoctrine()->getRepository('UserBundle:User')->createQueryBuilder('u')
                    ->select('u.id, u.username, u.name, u.companyName')
                    ->where('u.id IN (:userId)')
                    ->setParameter('userId', $userList)
                    ->getQuery();
                $userList = [];
                foreach ($query->getArrayResult() as $user) {
                    $name = '';
                    // Firstname
                    if (null !== $user['name'] && '' != trim($user['name'])) {
                        $name .= trim($user['name']).' ';
                    }
                    // Username if no firstname or lastname
                    if ('' == $name) {
                        $name = trim($user['username']);
                    }
                    // CompanyName
                    if (null !== $user['companyName'] && '' != trim($user['companyName'])) {
                        $name .= ' ('.trim($user['companyName']).')';
                    }

                    $userList[$user['id']] = $name;
                }

                // Build result list
                foreach ($policyList as $policy) {
                    $list[] = [
                        'id' => $policy->id,
                        'user' => ['id' => $policy->user, 'name' => $userList[$policy->user]],
                        'name' => htmlspecialchars($policy->name),
                        'description' => nl2br(htmlspecialchars($policy->description)),
                        'license' => isset($policy->license) ? $policy->license : '',
                        'allowEdit' => ($this->getUser()->getId() == $policy->user),
                    ];
                }
            }
        } catch (MediaConchServerException $e) {
            // Empty list
        }

        return new JsonResponse(['list' => $list]);
    }

    /**
     * Unpublish a public policy.
     *
     * @return json
     * @Route("/publicpolicies/unpublish/{id}", requirements={"id": "\d+"})
     * @Method({"PUT"})
     */
    public function publicPoliciesUnpublishAction(
        $id,
        XslPolicyEditVisibility $policyEditVisibility,
        XslPolicySave $policySave
    ) {
        try {
            // Make policy private
            $policyEditVisibility->editVisibility($id, false);

            // Save policy
            $policySave->save($id);

            return new JsonResponse(['policyId' => $id]);
        } catch (MediaConchServerException $e) {
            return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
        }
    }

    /**
     * User policies list.
     *
     * @return json
     * @Route("/userpolicies/list")
     * @Method({"GET"})
     */
    public function userPoliciesListAction(XslPolicyGetPolicies $policies)
    {
        $list = [];

        try {
            // Get public policies from server
            $policies->getPolicies([]);
            $policyList = $policies->getResponse()->getPolicies();
            if (0 < count($policyList)) {
                // Build result list
                foreach ($policyList as $policy) {
                    // Remove system policies
                    if (false === $policy->is_system) {
                        $list[] = [
                            'id' => $policy->id,
                            'name' => htmlspecialchars($policy->name),
                            'description' => nl2br(htmlspecialchars($policy->description)),
                        ];
                    }
                }
            }

            return new JsonResponse(['list' => $list]);
        } catch (MediaConchServerException $e) {
            return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
        }
    }

    /**
     * User policies get policy.
     *
     * @param int id policy ID of the policy to import
     *
     * @return XML
     * @Route("/userpolicies/policy/{id}", requirements={"id": "\d+"})
     * @Method({"GET"})
     */
    public function userPoliciesPolicyExportAction($id, XslPolicyExport $policyExport)
    {
        try {
            // Get policy XML
            $policyExport->export($id);

            $response = new Response($policyExport->getPolicyXml());
        } catch (MediaConchServerException $e) {
            $response = new Response('<?xml version="1.0"?><error />', $e->getStatusCode());
        }

        $response->headers->set('Content-Type', 'xml');

        return $response;
    }
}
