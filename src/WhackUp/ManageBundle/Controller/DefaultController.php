<?php

namespace WhackUp\ManageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user= $this->getUser();
        $admin_right = $this->get('rh_whackup.service.role')->isGranted('ROLE_SUPER_ADMIN', $user);
        // if you aren't admin or super admin
        if ( !$admin_right ) {
            return $this->redirectToRoute('admin_logout');
        }

        return $this->render('WhackUpManageBundle:Default:index.html.twig');
    }

}
