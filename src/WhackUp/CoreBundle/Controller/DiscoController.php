<?php

namespace WhackUp\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class DiscoController extends Controller
{
    public function indexAction(Request $request)
    {
        $user= $this->getUser();
        $super_admin_right = $this->get('rh_whackup.service.role')->isGranted('ROLE_SUPER_ADMIN', $user);
        $admin_right = $this->get('rh_whackup.service.role')->isGranted('ROLE_ADMIN', $user);
        // if you are admin or super admin
        if ($admin_right || $super_admin_right ) {
            return $this->redirectToRoute('fos_user_security_logout');
        }

        return $this->render('WhackUpCoreBundle:Disco:index.html.twig');
    }

    public function discoAction(Request $request)
    {
        return $this->render('WhackUpCoreBundle:Disco:disco.html.twig');
    }

    public function favouriteAction(Request $request)
    {
        return $this->render('WhackUpCoreBundle:Disco:favourite.html.twig');
    }

    public function aroundAction(Request $request)
    {
        return $this->render('WhackUpCoreBundle:Disco:around.html.twig');
    }

    public function usAction(Request $request)
    {
        return $this->render('WhackUpCoreBundle:Disco:us.html.twig');
    }

    public function sliderAction(Request $request)
    {
        return $this->render('WhackUpCoreBundle:Disco:slider.html.twig');
    }
}
