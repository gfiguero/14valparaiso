<?php

namespace Unisystem\MemberBundle\Entity;

use Doctrine\ORM\EntityRepository;

class MemberRepository extends EntityRepository
{
    public function getFrontpageList()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('m')
            ->from('UnisystemMemberBundle:Member', 'm')
            ->leftJoin('m.role', 'mr')
            ->orderBy('mr.rank', 'DESC')
            ->getQuery();

        return $qb->getResult();
    }
}