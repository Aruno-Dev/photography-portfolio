<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\QuotesService;


class HomeController extends AbstractController
{
    /**
     *  @Route("/")
     * @Route("/home", name="home")
     */
    public function index(AlbumRepository $albumRepo, ImageRepository $imageRepo)
    {
        $albums = $albumRepo->FindAllDesc();
        $images = $imageRepo->FindAllDesc();
        return $this->render('home/index.html.twig', [
            'controller' => 'home',
            'albums'     => $albums,
            'images'     => $images
        ]);
    }

    /**
     *  
     * @Route("/about", name="about")
     */
    public function about(AlbumRepository $albumRepo, QuotesService $quotes)
    {
        $albums = $albumRepo->FindAllDesc();
        return $this->render('home/about.html.twig', [
            'controller' => 'home',
            'albums'     => $albums,
            'quotes'     => $quotes->quotes
        ]);
    }
}
