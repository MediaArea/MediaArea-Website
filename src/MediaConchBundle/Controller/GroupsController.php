<?php

namespace MediaConchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MediaConchBundle\Lib\Checks\Groups;

/**
 * @Route("/Groups")
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class GroupsController extends Controller
{
    /**
     * @Route("", name="groups_home")
    * @Template()
     */
    public function groupsAction(Groups $groups)
    {
        header('X-Robots-Tag: none');

        $items = $groups->listGroups();
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $items ]);
    }
    
    /**
     * @Route("/{groupId}", name="mc_groups1")
     * @Template()
     */
    public function group1Action(Groups $groups, $groupId)
    {
        $items = $groups->listGroupInfo($groupId);
        if (!$items) {
            throw $this->createNotFoundException('This group is not found in our database');
        }
        return $this->render('@MediaConch/Default/checks.html.twig', [ 'items' => $items ]);
    }
}
