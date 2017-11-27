<?php

namespace VoteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use VoteBundle\Model\FeatureInterface;

class FeatureRepository extends EntityRepository
{
    public function getOpenFeatures()
    {
        return $this->createQueryBuilder('f')
            ->where('f.status >= :status')
            ->setParameter('status', FeatureInterface::STATUS_OPEN)
            ->getQuery()
            ->getResult();
    }

    public function getOpenFeaturesWithUserVotes($user)
    {
        return $this->getEntityManager()->createQuery('
            SELECT f, SUM(v.points) as totalPoints
            FROM VoteBundle:Feature f
            LEFT JOIN VoteBundle:Vote v WITH v.feature = f.id AND v.user = :user
            WHERE f.status >= :status
            GROUP BY f.id
            ')
            ->setParameter('user', $user)
            ->setParameter('status', FeatureInterface::STATUS_OPEN)
            ->getResult();
    }

    public function getFeaturesVotedByUser($user)
    {
        return $this->getEntityManager()->createQuery('
            SELECT f.id, f.slug, f.title
            FROM VoteBundle:Feature f
            LEFT JOIN VoteBundle:Vote v WITH v.feature = f.id AND v.user = :user
            WHERE f.status >= :status
            GROUP BY f.id
            HAVING SUM(v.points) > 0
            ')
            ->setParameter('user', $user)
            ->setParameter('status', FeatureInterface::STATUS_OPEN)
            ->getResult();
    }
}
