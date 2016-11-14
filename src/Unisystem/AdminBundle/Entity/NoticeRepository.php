<?php

namespace Unisystem\AdminBundle\Entity;

/**
 * NoticeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NoticeRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAdminList($sort = null, $direction = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select('n')
            ->from('UnisystemAdminBundle:Notice', 'n')
        ;

        if($sort && $direction)
        {
            $sort = 'h.'.$sort;
            $qb ->orderBy($sort, $direction);
        }

        return $qb->getQuery()->getResult();        
    }

    public function getFrontpageList()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('n')
            ->from('UnisystemAdminBundle:Notice', 'n')
            ->orderBy('n.createdAt', 'DESC')
        ;
        return $qb->getQuery()->getResult();
    }
}
