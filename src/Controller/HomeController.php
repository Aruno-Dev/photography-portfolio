<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     *  @Route("/")
     * @Route("/home", name="home")
     */
    public function index(ImageRepository $imageRepo)
    {
        $numberOfImages = count($imageRepo->findAll());
        $images = $imageRepo->FindThreeDesc();
      
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'numberOfImages' => $numberOfImages,
            'images' => $images
            
        ]);
    }


    
}
