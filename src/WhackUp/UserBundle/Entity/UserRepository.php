<?php

namespace WhackUp\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function nbreUsers()
    {
        $qb = $this
            ->createQueryBuilder('u')  //SELECT COUNT(d) FROM WhackUpManageBundle:Disco
            ->select('COUNT(u)');
        ;

        $result = $qb->getQuery()->getSingleScalarResult();

        return $result;
    }

    public function findByGroup($group)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from($this->_entityName, 'u');

        if($group == "ROLE_USER"){
           $qb = $qb->where('u.roles NOT LIKE :role1 OR u.roles NOT LIKE :role2')
                     ->setParameter('role1', '%"ADMIN"%')
                     ->setParameter('role2', '%"PRENIUM"%');
        }
        else{
            $qb = $qb->where('u.roles LIKE :roles')
                     ->setParameter('roles', '%"'.$group.'"%');
        }
        $qb = $qb->orderBy('u.id', 'DESC');

        $result = $qb->getQuery()->getResult();

        return $result;
    }

    public function nbreUsersByGroup($group)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(u)')
            ->from($this->_entityName, 'u');

        if($group == "ROLE_USER"){
            $qb = $qb->where('u.roles NOT LIKE :role1 OR u.roles NOT LIKE :role2')
                ->setParameter('role1', '%"ADMIN"%')
                ->setParameter('role2', '%"PRENIUM"%');
        }
        else{
            $qb = $qb->where('u.roles LIKE :roles')
                ->setParameter('roles', '%"'.$group.'"%');
        }

        $result = $qb->getQuery()->getSingleScalarResult();

        return $result;
    }
}
