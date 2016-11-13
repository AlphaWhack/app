<?php

namespace WhackUp\UserBundle\Controller;

use WhackUp\UserBundle\Entity\User;
use WhackUp\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);
                
                //Ajout edgard
                //$this->sendMail();
                //$this->get(‘mail_whackup.service’)->sendRefusMessage($user);
                //=====On filtre les serveurs qui dérangent lol.
                $mail = 'edgard.nkenfack@gmail.com';
                if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
                    $passage_ligne = "\r\n";
                else
                   $passage_ligne = "\n";

                $lien = "whack/add_userBDD.php?user=edgard&statut=not_validate";

                //=====Déclaration des messages au format texte et au format HTML.
                $message_txt = "Salut jeune Whackup'peeps et bienvenue dans la Whackup'sphère.".$passage_ligne;
                $message_txt .= "Pour profiter dès maintenant d'une expérience musicale unique, valide ton inscription en cliquant sur le lien ci dessous".$passage_ligne;
                

                $message_html = "<html><head></head><body>Salut jeune Whackup'peeps et bienvenue dans la Whackup'sphère.<br>";
                $message_html .= "Pour profiter dès maintenant d'une expérience musicale unique, valide ton inscription en cliquant sur le lien ci dessous ou en faisant un copier coller dans ta barre d'adresse<br>";
                $message_html .= "<b><i><a href = \"whack/add_userBDD.php?user=edgard&statut=not_validate\" > Valider mon inscription.</a></i></b></body></html>";
                $message_html .= $lien;
                
                //==========//=====Création de la boundary
                $boundary = "-----=".md5(rand());
                //==========                                                                                                                                                                                                         
                //=====Définition du sujet.
                $sujet = "Inscription Whack'up";
                //=========

                //=====Création du header de l'e-mail
                $header = "From: \"WackUp\"<whackupessai@gmail.fr>".$passage_ligne;          //  Expéditeur
                $header .= "Reply-to: \"WackUp\"<whackupessai@gmail.fr>".$passage_ligne;     //  Retour
                $header .= "MIME-Version: 1.0".$passage_ligne;                          //MIME
                $header .= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
                //==========

                //=====Création du message.
                $message = $passage_ligne."--".$boundary.$passage_ligne;

                //=====Ajout du message au format texte.
                $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
                $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
                $message.= $passage_ligne.$message_txt.$passage_ligne;

                //==========
                $message.= $passage_ligne."--".$boundary.$passage_ligne;

                //=====Ajout du message au format HTML
                $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
                $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
                $message.= $passage_ligne.$message_html.$passage_ligne;

                //==========
                $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
                $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
                //==========

                //=====Envoi de l'e-mail.
                $mail1 = "edgard.nkenfack@gmail.com";
                mail($mail1,$sujet,$message,$header);
                //==========
                //Fin ajout
                $message = "Un mail de confirmation vous a été envoyé ... ";

                return $this->render('WhackUpUserBundle:Default:register.html.twig', array(
                    'form' => $form->createView(),
                    'message_form' => $message,
                ));
            }

            $event = new FormEvent($form, $request);
            //$dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        $message = "";

        return $this->render('WhackUpUserBundle:Default:register.html.twig', array(
            'form' => $form->createView(),
            'message_form' => $message,
        ));

    }
    
    private function sendMail(){
        $message = \Swift_Message::newInstance()
            ->setSubject('Sujet')
            ->setFrom(array('whackup@gmail.com' => 'Nom prénom'))
            ->setTo('edgard.nkenfack@gmail.com')
            ->setBody('Contenu du mail', 'text/plain', 'UTF-8')
        ;
 
        $this->get('mailer')->send($message);
    }


}
