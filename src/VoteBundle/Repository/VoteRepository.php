<?php

namespace VoteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\UserInterface;
use VoteBundle\Model\FeatureInterface;

class VoteRepository extends EntityRepository
{
    public function getTotalVotesByUserAndFeature(UserInterface $user, FeatureInterface $feature)
    {
        $votes = $this->createQueryBuilder('v')
            ->select('SUM(v.points) as totalPoints')
            ->where('v.user = :user')
            ->andWhere('v.feature = :feature')
            ->setParameters(['user' => $user, 'feature' => $feature])
            ->getQuery()
            ->getSingleResult();

        return $votes['totalPoints'] ?? 0;
    }

    public function getTotalVotesByUser(UserInterface $user)
    {
        $votes = $this->createQueryBuilder('v')
            ->select('SUM(v.points) as totalPoints')
            ->where('v.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleResult();

        return $votes['totalPoints'] ?? 0;
    }

    public function getFeaturesVotedByUser($user)
    {
        return $this->createQueryBuilder('v')
            ->select('SUM(v.points) as totalPoints, f.id, f.slug, f.title')
            ->join('v.feature', 'f')
            ->where('v.user = :user')
            ->andWhere('f.status >= :status')
            ->setParameter('user', $user)
            ->setParameter('status', FeatureInterface::STATUS_OPEN)
            ->groupBy('v.feature')
            ->getQuery()
            ->getResult();
    }
}
