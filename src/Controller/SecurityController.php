<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
     * @Route("/security")
     */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="user_login")
     */
    public function login(AuthenticationUtils $auth)
    {
        $error = $auth->getLastAuthenticationError();
        return $this->render('security/login.html.twig', [
        'error' => $error]);
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logout()
    {

    }

   
}
