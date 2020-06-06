<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Form\CommentType;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * @Route("/image/{id<[0-9]+>}/comment", name="image_comment")
     */
    public function newComment(Request $request, EntityManagerInterface $manager, Image $image, AlbumRepository $albumRepo)
    {
        $albums  = $albumRepo->findAll();
        $album   = $image->getAlbum();
        $comment = new Comment();
        $form    = $this->createForm(CommentType::class , $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           $comment->setImage($image);
           $manager->persist($comment);
           $manager->flush();

            $this->addFlash('success', 'Comment added successfully !');

            return $this->redirectToRoute('portfolio_show', ['id' => $album->getId()]);
        }

        return $this->render('comments/image_comments.html.twig', [
            'controller' => 'image',
            'form'       => $form->createView(),
            'album'      => $album,
            'image'      => $image,
            'albums'     => $albums
        ]);
    }
}
