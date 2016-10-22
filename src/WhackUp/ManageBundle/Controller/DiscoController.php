<?php

namespace WhackUp\ManageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use WhackUp\ManageBundle\Entity\Disco;
use WhackUp\ManageBundle\Form\DiscoType;
use WhackUp\ManageBundle\Entity\ImageDiso;

class DiscoController extends Controller
{
    public function indexAction(Request $request)
    {
        $user= $this->getUser();
        $admin_right = $this->get('rh_whackup.service.role')->isGranted('ROLE_SUPER_ADMIN', $user);
        // if you aren't admin or super admin
        if ( !$admin_right ) {
            return $this->redirectToRoute('admin_logout');
        }

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('WhackUpManageBundle:Disco')
        ;
        $listDisco = $repository->findAll();

        $nbreDiscos = $repository ->nbreDisco();
                    ;

        return $this->render('WhackUpManageBundle:Disco:index.html.twig',
            array(
                'discos' => $listDisco,
                'nbrediscos' => $nbreDiscos,
            ));
    }

    public function addDiscoAction(Request $request)
    {
        $message = "";
        $user= $this->getUser();
        $admin_right = $this->get('rh_whackup.service.role')->isGranted('ROLE_SUPER_ADMIN', $user);
        // if you aren't admin or super admin
        if ( !$admin_right ) {
            return $this->redirectToRoute('admin_logout');
        }

        $disco = new Disco();
        $form = $this->get('form.factory')->create(DiscoType::class, $disco);

       $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($disco);
            $em->flush();

            $message = $disco->getNom();

            $disco = new Disco();
            $form = $this->get('form.factory')->create(DiscoType::class, $disco);
            return $this->render('WhackUpManageBundle:Disco:add.html.twig', array(
                'form' => $form->createView(),
                'message' => $message,
            ));
        }


        return $this->render('WhackUpManageBundle:Disco:add.html.twig', array(
            'form' => $form->createView(),
            'message' => $message,
        ));
    }

}
