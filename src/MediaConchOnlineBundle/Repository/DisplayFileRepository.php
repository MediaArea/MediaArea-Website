<?php

namespace MediaConchOnlineBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * DisplayFileRepository.
 */
class DisplayFileRepository extends EntityRepository
{
    public function getUserAndSystemDisplays($user)
    {
        $list = [];
        $displays = $this->getEntityManager()->getRepository('MediaConchOnlineBundle:DisplayFile')->findByUser($user);
        foreach ($displays as $display) {
            $list['User displays'][$display->getId()] = $display;
        }
        $displays = $this->getEntityManager()->getRepository('MediaConchOnlineBundle:DisplayFile')->findByUser(null);
        foreach ($displays as $display) {
            $list['System displays'][$display->getId()] = $display;
        }

        return $list;
    }

    public function getUserAndSystemDisplaysChoices($user)
    {
        $list = [];
        $displays = $this->getEntityManager()->getRepository('MediaConchOnlineBundle:DisplayFile')->findByUser($user);
        foreach ($displays as $display) {
            $list['User displays'][$display->getDisplayName()] = $display->getId();
        }
        $displays = $this->getEntityManager()->getRepository('MediaConchOnlineBundle:DisplayFile')->findByUser(null);
        foreach ($displays as $display) {
            $list['System displays'][$display->getDisplayName()] = $display->getId();
        }

        return $list;
    }

    public function findOneByUserOrSystem($display, $user)
    {
        $query = $this->getEntityManager()->getRepository('MediaConchOnlineBundle:DisplayFile')->createQueryBuilder('d')
            ->where('d.id = :displayID AND d.user = :userID')
            ->orWhere('d.id = :displayID AND d.user IS NULL')
            ->setParameter('displayID', $display)
            ->setParameter('userID', $user)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}
