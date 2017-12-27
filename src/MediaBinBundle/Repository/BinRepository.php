<?php

namespace MediaBinBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use MediaBinBundle\Model\BinInterface;

class BinRepository extends EntityRepository
{
    public function getExpiredBin($limit = 10)
    {
        $expireDate = new \DateTime();
        // Keep bin during 7 days after expiration
        $expireDate->add(new \DateInterval('P7D'));

        return $this->createQueryBuilder('b')
            ->where('b.expireAt < :expire')
            ->setParameter('expire', $expireDate)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function getLatestsPublicBin($offset = 0, $limit = 10)
    {
        $queryBuilder = $this->createQueryBuilder('b')
            ->where('b.expireAt > :expire')
            ->andWhere('b.visibility = :visibility')
            ->setParameter('expire', new \DateTime())
            ->setParameter('visibility', BinInterface::VISIBILITY_PUBLIC)
            ->orderBy('b.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return new Paginator($queryBuilder, false);
    }

    public function getUserBin($user, $offset = 0, $limit = 10)
    {
        $queryBuilder = $this->createQueryBuilder('b')
            ->where('b.user = :user')
            ->setParameter('user', $user)
            ->orderBy('b.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return new Paginator($queryBuilder, false);
    }
}
