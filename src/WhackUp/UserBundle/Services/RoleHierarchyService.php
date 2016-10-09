<?php

namespace WhackUp\UserBundle\Services;

/**
 * Created by PhpStorm.
 * User: Hervé MVENG
 * Date: 07/10/2016
 * Time: 21:50
 */

use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class RoleHierarchyService
{
    private $roleHierarchy;

    /**
     * Constructor
     *
     * @param RoleHierarchyInterface $roleHierarchy
     */
    public function __construct(RoleHierarchyInterface $roleHierarchy)
    {
        $this->roleHierarchy = $roleHierarchy;
    }

    /**
     * isGranted
     *
     * @param string $role
     * @param $user
     * @return bool
     */
    public function isGranted($role, $user) {

        $role = new Role($role);

        foreach($user->getRoles() as $userRole) {
            if (in_array($role, $this->roleHierarchy->getReachableRoles(array(new Role($userRole)))))
                return true;
        }

        return false;
    }
}