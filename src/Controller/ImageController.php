<?php

namespace App\Controller;

use App\Entity\Commentary;
use App\Entity\Image;
use App\Form\CommentaryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * @Route("/image/{id<[0-9]+>}/comment", name="image_comment")
     */
    public function newComment(Request $request, EntityManagerInterface $manager, Image $image)
    {

        $album = $image->getAlbum();
        $comment = new Commentary();
        $form = $this->createForm(CommentaryType::class , $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           $comment->setImage($image);
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('success', 'Comment added successfully !');
            

            return $this->redirectToRoute('portfolio_show', ['id' =>$album->getId()]);

        }
        
       

        return $this->render('image/comment.html.twig', [
            'controller_name' => 'ImageController',
            'form'=> $form->createView(),
            'album' => $album,
            'image' => $image
        ]);
    }
}
