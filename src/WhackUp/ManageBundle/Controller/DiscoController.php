<?php

namespace WhackUp\ManageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use WhackUp\ManageBundle\Entity\Disco;
use WhackUp\ManageBundle\Form\DiscoType;
use WhackUp\ManageBundle\Form\ImageDiscoType;
use WhackUp\ManageBundle\Entity\ImageDisco;

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

        return $this->render('WhackUpManageBundle:Disco:index.html.twig',
            array(
                'discos' => $listDisco,
                'nbrediscos' => $nbreDiscos,
            ));
    }

    public function addAction(Request $request)
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

    public function viewAction(Request $request,$id)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('WhackUpManageBundle:Disco')
        ;
        $disco = $repository->find($id);

        if($disco == null){
            return $this->redirectToRoute('whack_up_manage_disco');
        }

        return $this->render('WhackUpManageBundle:Disco:view.html.twig', array(
            'disco' => $disco,
        ));
    }

    public function editAction(Request $request,$id)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('WhackUpManageBundle:Disco')
        ;
        $disco = $repository->find($id);

        if($disco == null){
            $err = "error sur ".$id;
            var_dump($err);
            die;
        }

        $message = "";
        //$discoObj = new Disco();
        $form = $this->get('form.factory')->create(DiscoType::class, $disco);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($disco);
            $em->flush();

            $message = $disco->getNom();

            return $this->render('WhackUpManageBundle:Disco:edit.html.twig', array(
                'form' => $form->createView(),
                'message' => $message,
                'disco' => $disco,
            ));
        }

        return $this->render('WhackUpManageBundle:Disco:edit.html.twig', array(
            'form' => $form->createView(),
            'message' => $message,
            'disco' => $disco,
        ));
    }

    public function editImageAction(Request $request,$id)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('WhackUpManageBundle:Disco')
        ;
        $disco = $repository->find($id);

        $message = "";
        $new_image = new ImageDisco();
        //$new_image = ImageDisco::class;
        $form = $this->get('form.factory')->create(ImageDiscoType::class, $new_image);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // get id old picture
            $old_image = $disco->getImage();

            // moving image
            $new_image->upload();
            // set image to user
            $disco->setImage($new_image);

            // insert into BD
            $em = $this->getDoctrine()->getManager();
            $em->persist($disco);

            // if image (old picture) is already define
            if($old_image != null){
                // get old picture on database to remove that on file
                $repository = $em->getRepository('WhackUpManageBundle:ImageDisco');
                $imageToRemove = $repository->find($old_image->getId());
                //remove old picture on folder
                if($imageToRemove != null){
                    $nameImageToRemove = $imageToRemove->getUrl();
                    $oldFile = __DIR__.'/../../../../web/'.$imageToRemove->getUploadDir().'/'.$nameImageToRemove;
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                $em->remove($old_image);
            }
            $em->flush();

            $message = "You picture have been updated ...";

        }

        return $this->render('WhackUpManageBundle:Disco:image.html.twig', array(
            'form' => $form->createView(),
            'msg_form' => $message,
            'disco' => $disco,
        ));
    }

}
