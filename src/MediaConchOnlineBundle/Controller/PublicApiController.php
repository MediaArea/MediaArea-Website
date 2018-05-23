<?php

namespace MediaConchOnlineBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Lib\ApiKey\ApiKeyManager;
use MediaConchOnlineBundle\Lib\MediaConch\InitInstanceId;
use MediaConchOnlineBundle\Lib\MediaConch\MediaConchServerException;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyGetPoliciesCount;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyExport;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyGetPolicy;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyGetPublicPolicies;

/**
 * @Route("/MediaConchOnline/api/public/v1")
 */
class PublicApiController extends Controller
{
    /**
     * Public policies page.
     *
     * @return json
     * @Route("/publicpolicies/list", name="mco_api_public_policy_public")
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
                    // Name
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
     * Public policies get policy.
     *
     * @param int id policy ID of the policy to import
     * @param int userId user ID of the policy to import
     *
     * @return json
     *              {"policy":POLICY_JSTREE_JSON}
     * @Route(
     *     "/publicpolicies/policy/{id}/{userId}",
     *     requirements={"id": "\d+", "userId": "\d+"},
     *     name="mco_api_public_policy"
     * )
     */
    public function publicPoliciesPolicyAction($id, $userId, XslPolicyGetPolicy $policy)
    {
        try {
            // Get policy
            $policy->getPublicPolicy($id, $userId, 'JSTREE');

            return new JsonResponse($policy->getResponse()->getPolicy());
        } catch (MediaConchServerException $e) {
            return new JsonResponse(['message' => 'Error'], $e->getStatusCode());
        }
    }

    /**
     * Public policies get policy.
     *
     * @param int id policy ID of the policy to import
     * @param int userId user ID of the policy to import
     *
     * @return XML
     * @Route(
     *     "/publicpolicies/policy/export/{id}/{userId}",
     *     requirements={"id": "\d+", "userId": "\d+"},
     *     name="mco_api_public_policy_public_export"
     * )
     */
    public function publicPoliciesPolicyExportAction($id, $userId, XslPolicyExport $policyExport)
    {
        try {
            // Get policy XML
            $policyExport->publicExport($id, $userId);

            $response = new Response($policyExport->getPolicyXml());
        } catch (MediaConchServerException $e) {
            $response = new Response('<?xml version="1.0"?><error />', $e->getStatusCode());
        }

        $response->headers->set('Content-Type', 'xml');

        return $response;
    }

    /**
     * Get the ApiKey for a user.
     *
     * @return json
     * @Route("/login/ckeck", name="mco_api_public_get_api_key")
     * @Method({"POST"})
     */
    public function getApiKeyAction(Request $request, ApiKeyManager $apiKeyManager)
    {
        // Get the username value
        $username = $request->request->get('username');
        // Get the password value
        $password = $request->request->get('password');
        // Get the app value
        $app = $request->request->get('app');
        // Get the app version value
        $version = $request->request->get('version');

        $apiKey = $apiKeyManager->getApiKeyForUser($username, $password, $app, $version);

        if ($apiKey) {
            return new JsonResponse(['key' => $apiKey->getToken()]);
        }

        return new JsonResponse(['error' => 'Invalid user or password'], 401);
    }

    /**
     * Count policies for a user.
     *
     * @return json
     * @Route("/policies/count/{userId}", requirements={"userId": "\d+"},
     *   name="mco_api_public_policies_count")
     * @Method({"GET"})
     */
    public function policiesCountAction(XslPolicyGetPoliciesCount $policiesCount, Request $request, $userId)
    {
        $apiConfig = $this->getParameter('mco.api');
        if ($apiConfig['token'] != $request->headers->get('X-API-TOKEN')) {
            return new JsonResponse(['error' => 'Invalid token'], 401);
        }

        try {
            $policiesCount->getPoliciesCountByUser($userId);
            $xslPolicy = $policiesCount->getResponse()->getCount();
        } catch (MediaConchServerException $e) {
            $xslPolicy = 0;
        }

        return new JsonResponse(['policiesCount' => $xslPolicy]);
    }
}
