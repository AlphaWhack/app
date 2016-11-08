<?php

namespace WhackUp\ManageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use WhackUp\ManageBundle\Entity\Advert;
use WhackUp\ManageBundle\Form\AdvertType;

class AdvertController extends Controller
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
            ->getRepository('WhackUpManageBundle:Advert')
        ;
        $adverts = $repository->findBy(array(),array('created' => 'desc')); //findAll();

        $nbreAdvert = $repository ->nbreAdvert();

        return $this->render('WhackUpManageBundle:Advert:index.html.twig',
            array(
                'adverts' => $adverts,
                'nbreadvert' => $nbreAdvert,
            ));
    }

    public function addAction(Request $request)
    {
        $message = "";

        $advert = new Advert();
        $form = $this->get('form.factory')->create(AdvertType::class, $advert);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // var_dump($advert);
            //die;

            // moving image
            $advert->upload();
            // save
            $em->persist($advert);
            $em->flush();

            $message = $advert->getTitle();

            $advert = new Advert();
            $form = $this->get('form.factory')->create(AdvertType::class, $advert);
            return $this->render('WhackUpManageBundle:Advert:add.html.twig', array(
                'form' => $form->createView(),
                'message' => $message,
            ));
        }

        return $this->render('WhackUpManageBundle:Advert:add.html.twig', array(
             'form' => $form->createView(),
             'message' => $message,
        ));
    }

    public function viewAction(Request $request,$id)
    {
        return $this->render('WhackUpManageBundle:Advert:view.html.twig', array(
            //'disco' => $disco,
        ));
    }

    public function editAction(Request $request,$id)
    {

        return $this->render('WhackUpManageBundle:Advert:edit.html.twig', array(
            //'form' => $form->createView(),
            //'message' => $message,
            //'disco' => $disco,
        ));
    }

}
