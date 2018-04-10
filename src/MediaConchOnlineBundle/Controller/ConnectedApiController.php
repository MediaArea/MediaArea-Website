<?php

namespace MediaConchOnlineBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use MediaConchOnlineBundle\Lib\MediaConch\InitInstanceId;
use MediaConchOnlineBundle\Lib\MediaConch\MediaConchServerException;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyEditVisibility;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicyGetPublicPolicies;
use MediaConchOnlineBundle\Lib\XslPolicy\XslPolicySave;

/**
 * @Route("/MediaConchOnline/api/connected/v1")
 */
class ConnectedApiController extends BaseController
{
    /**
     * Public policies list.
     *
     * @return json
     * @Route("/publicpolicies/list", name="mco_api_connected_policy_public")
     * @Method({"GET"})
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
                    // Username if no name
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
     * @Route("/publicpolicies/unpublish/{id}", requirements={"id": "\d+"}, name="mco_api_connected_policy_unpublish")
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
}
