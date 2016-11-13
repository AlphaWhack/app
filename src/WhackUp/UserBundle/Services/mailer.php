<?php

// Edgard : 06/11/16

namespace WhackUp\UserBundle\Services;

use Symfony\Component\Templating\EngineInterface;

class Mailer
{
    protected $mailer;
    protected $templating;
    private $from = "no-reply@example.fr";
    private $reply = "contact@example.fr";
    private $name = "Equipe Acme Blog";

    public function __construct($mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    protected function sendMessage($to, $subject, $body)
    {
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom(array('whackup@gmail.com' => 'Nom prénom'))
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->setReplyTo($this->reply,$name)
            ->setContentType(‘text/html’);

        $this->mailer->send($mail);
    }
}

public function sendRefusMessage(\WhackUp\UserBundle\Entity\User $user)
{
    $subject = "Votre annonce à été refusée";
    //$template = ‘WhackupUserBundle:Mail:refus.html.twig’;
    $to = 'edgard.nkenfack@gmail.com';//$user->getEmail()
    $body = 'Vous êtes bien inscrit' ;//$this->templating->render($template, array(‘user’ => $user))
    $this->sendMessage($to, $subject, $body);
}


