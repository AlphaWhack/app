<?php

namespace WhackUp\ManageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

class UsersController extends Controller
{
    public function indexAction(Request $request)
    {
        $user= $this->getUser();
        $admin_right = $this->get('rh_whackup.service.role')->isGranted('ROLE_SUPER_ADMIN', $user);
        // if you aren't admin or super admin
        if ( !$admin_right ) {
            return $this->redirectToRoute('admin_logout');
        }

        //get list group by hierachy of system
        $getListRoles = $this->getParameter('security.role_hierarchy.roles');
        $roles = new ArrayCollection();
        foreach($getListRoles as $keyRole => $valueRole){
            $roles->add($keyRole);
            if(is_array($valueRole)){
                foreach($valueRole as $keyValueRole){
                    $roles->add($keyValueRole);
                }
            }
        }

        // get group by url
        $group = $request->query->get('group');
        if($roles->contains($group)){
            // list by group
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('WhackUpUserBundle:User')
            ;

            $users = $repository->findByGroup($group);
            $nbreUsers = $repository->nbreUsersByGroup($group);
            $tab_init = array("ROLE_", "_", "USER PRENIUM");
            $tab_end   = array("", " ", "PRENIUM");
            $group = str_replace($tab_init, $tab_end, $group);

            return $this->render('WhackUpManageBundle:Users:index.html.twig',
                array(
                    'users' => $users,
                    'nbreuser' => $nbreUsers,
                    'listroles' => $roles,
                    'group' => $group,
                ));
        }
        else{
            // by default all users
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('WhackUpUserBundle:User')
            ;
            $users = $repository->findBy(array(),array('id' => 'desc')); //findAll();
            $nbreUsers = $repository ->nbreUsers();
            $group = "utilisateurs";
            return $this->render('WhackUpManageBundle:Users:index.html.twig',
                array(
                    'users' => $users,
                    'nbreuser' => $nbreUsers,
                    'listroles' => $roles,
                    'group' => $group,
                ));
        }
    }

    public function viewAction(Request $request,$id)
    {

    }

}
