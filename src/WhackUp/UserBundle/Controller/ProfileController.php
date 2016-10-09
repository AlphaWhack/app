<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WhackUp\UserBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use WhackUp\UserBundle\Form\ImageType;
use WhackUp\UserBundle\Entity\Image;

/**
 * Created by PhpStorm.
 * User: Hervé MVENG
 * Date: 07/10/2016
 * Time: 21:50
 */

class ProfileController extends Controller
{
    /**
     * Show the user
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $super_admin_right = $this->get('rh_whackup.service.role')->isGranted('ROLE_SUPER_ADMIN', $user);
        $admin_right = $this->get('rh_whackup.service.role')->isGranted('ROLE_ADMIN', $user);
        $prenium_right = $this->get('rh_whackup.service.role')->isGranted('ROLE_USER_PRENIUM', $user);
        $free_right = $this->get('rh_whackup.service.role')->isGranted('ROLE_USER', $user);
        $compte = "";

        if($free_right){ $compte = "FREE"; }
        if($prenium_right) { $compte = "PRENIUM"; }
        if($admin_right) { $compte = "ADMINISTRATEUR"; }
        if($super_admin_right) { $compte = "SUPER ADMINISTRATEUR"; }

        return $this->render('WhackUpUserBundle:Profile:show.html.twig', array(   //FOSUserBundle:Profile:show.html.twig
            'user' => $user,
            'compte' => $compte,
        ));
    }

    /**
     * Edit the user
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');

                $super_admin_right = $this->get('rh_whackup.service.role')->isGranted('ROLE_SUPER_ADMIN', $user);
                $admin_right = $this->get('rh_whackup.service.role')->isGranted('ROLE_ADMIN', $user);
                // if you are admin or super admin
                if ($admin_right || $super_admin_right ) {
                    $url = $this->generateUrl('admin_profile');
                }

                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('WhackUpUserBundle:Profile:edit.html.twig', array(  //FOSUserBundle:Profile:edit.html.twig
            'form' => $form->createView()
        ));
    }

    /**
     * define avatar  user
     */
    public function pictureAction(Request $request){

        $message = "";
        $user = $this->getUser();
        $new_image = new Image();
        $form = $this->get('form.factory')->create(ImageType::class, $new_image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // get id old picture
            $old_image = $user->getImage();

            // moving image
            $new_image->upload();
            // set image to user
            $user->setImage($new_image);

            // insert into BD
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            // if image (old picture) is already define
            if($old_image != null){
                // get old picture on database to remove that on file
                $repository = $em->getRepository('WhackUpUserBundle:Image');
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

        return $this->render('WhackUpUserBundle:Profile:avatar.html.twig', array(
            'form' => $form->createView(),
            'msg_form' => $message,
        ));
    }

    /**
     * parameter user
     */
    public function parameterAction(Request $request){

        return $this->render('WhackUpUserBundle:Profile:parameters.html.twig', array(
            //'form' => $form->createView()
        ));
    }
}











