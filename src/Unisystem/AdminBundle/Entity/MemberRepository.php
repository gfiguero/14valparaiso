<?php

namespace Unisystem\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

class MemberRepository extends EntityRepository
{
    public function getAdminList($sort = null, $direction = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select('m')
            ->from('UnisystemAdminBundle:Member', 'm')
            ->leftJoin('m.role', 'mr')
        ;

        if($sort && $direction)
        {
            $sort = 'm.'.$sort;
            $qb ->orderBy($sort, $direction);
        }

        return $qb->getQuery()->getResult();        
    }

    public function getFrontpageList()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('m')
            ->from('UnisystemAdminBundle:Member', 'm')
            ->leftJoin('m.role', 'mr')
            ->orderBy('m.code', 'ASC')
            ->getQuery();

        return $qb->getResult();
    }

    public function getOfficerList()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('m')
            ->from('UnisystemAdminBundle:Member', 'm')
            ->leftJoin('m.role', 'mr')
            ->where('mr.officer = TRUE')
            ->orderBy('mr.rank', 'DESC')
            ->getQuery();

        return $qb->getResult();
    }
}