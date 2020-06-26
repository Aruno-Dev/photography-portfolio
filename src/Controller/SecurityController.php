<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
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
    public function login(AuthenticationUtils $auth, AlbumRepository $albumRepo)
    {
        $albums = $albumRepo->FindAllDesc();
        $error  = $auth->getLastAuthenticationError();
        return $this->render('security/login.html.twig', [
        'error'      => $error,
        'albums'     => $albums,
        'controller' => 'security'
        ]);
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logout()
    {

    }

   
}
