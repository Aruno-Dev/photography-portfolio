<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Comment;
use App\Entity\Image;
use App\Form\CommentType;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class AlbumController extends AbstractController
{
    /**
     * @Route("/portfolio", name="portfolio")
     */
    public function index(AlbumRepository $albumRepo)
    {
        $albums = $albumRepo->findAll();
        return $this->render('album/index.html.twig', [
            'controller' => 'album',
            'albums'     => $albums,
        ]);
    }

    /**
     * @Route("/portfolio/{id<[0-9]+>}/show", name="portfolio_show", methods={"GET"})
     * @Route("/portfolio/{id<[0-9]+>}/show/{image}", name="portfolio_show_comment", requirements={"id" = "\d+"}, defaults={"image" = null}, methods={"GET"})
     */
    public function show(Album $album, AlbumRepository $albumRepo, Image $image = null)
    {
            $albums    = $albumRepo->findAll();
            $images    = $album->getImages();
            $comments = $album->getComments();
            $comment   = new Comment();
            $comment->setAlbum($album);
            
            $collection = [];
            foreach($images as $image){
                $comment = new Comment();
                $comment->setImage($image)->setAlbum($album);
                $collection[] = [
                    'image' => $image,
                ];
            }
        return $this->render('album/show.html.twig', [
            'controller' => 'album',
            'album'      => $album,
            'collection' => $collection,
            'albums'     => $albums,
            'comments'   => $comments
        ]);
    }

     /**
     * @Route("/portfolio/comment", name="post_comment", methods={"POST"})
     */
    public function post(Request $request, EntityManagerInterface $manager)
    {
            $comment = new Comment();
            $form    = $this->createForm(CommentType::class, $comment);
            $form->submit($request->request->get('comment'), false);
            try{
                $manager->persist($comment);
                $manager->flush();
                return new JsonResponse([
                    'success' => true, 
                    'comment' =>  $this->renderView('comments/comment.html.twig', [
                         'comment' => $comment
                     ])
                ]);
            }catch(Exception $e){
                return new JsonResponse([
                    'success' => false,
                    'message' => $e->getMessage() 
                    ]);
            }
    }

     /**
     * @Route("/portfolio/album/{id<[0-9]+>}/comments", name="album_comments", methods={"GET"})
     */
    public function showAlbumComments(Album $album)
    {
        return $this->getCommentsResponse($album);
    }

     /**
     * @Route("/portfolio/image/{id<[0-9]+>}/comments", name="image_comments", methods={"GET"})
     */
    public function showImageComments(Image $image)
    {
        return $this->getCommentsResponse($image);
    }

    private function getCommentsResponse($entity){

        $em       = $this->getDoctrine()->getManager();
        $comments = $em
                    ->getRepository(Comment::class)
                    ->findBy([
                        $entity instanceof Album ? "album" : "image" =>  $entity
                    ]);
        return new JsonResponse([
            'success' => true, 
            'view'   =>  $this->renderView('comments/list.html.twig', [
                 'comments' => $comments,
                 'album'    => $entity instanceof Image ? $entity->getAlbum() : $entity,
                 'image'    => $entity instanceof Image ? $entity : null
             ])
        ]);
    }
}
