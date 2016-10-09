<?php

namespace WhackUp\UserBundle\EventListener;

/**
 * Created by PhpStorm.
 * User: Hervé MVENG
 * Date: 05/10/2016
 * Time: 02:13
 */

use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginWhackup implements AuthenticationEntryPointInterface
{
    protected $router;

    public function __construct($router)
    {
        $this->router = $router;
    }

    /**
     * This method receives the current Request object and the exception by which the exception
     * listener was triggered.
     *
     * The method should return a Response object
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        if ($request->isXmlHttpRequest()) {

            return new JsonResponse('',401);

        }

        return new RedirectResponse($this->router->generate('fos_user_security_login'));
    }
}