<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Image;
use App\Entity\Commentary;
use App\Form\CommentaryType;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{
    /**
     * @Route("/portfolio", name="portfolio")
     */
    public function index(AlbumRepository $albumRepo)
    {
        $albums = $albumRepo->findAll();
       
        return $this->render('album/index.html.twig', [
            'controller_name' => 'AlbumController',
            'albums' => $albums,
            
        ]);
    }


    /**
     * @Route("/portfolio/{id<[0-9]+>}/show", name="portfolio_show")
     */
    public function show(Album $album, EntityManagerInterface $manager, Request $request)
    {
        $images = $album->getImages();
        
       
        return $this->render('album/show.html.twig', [
            'controller_name' => 'AlbumController',
            'album' => $album,
            'images' => $images
            
            
            
        ]);
    }

    


    
}
