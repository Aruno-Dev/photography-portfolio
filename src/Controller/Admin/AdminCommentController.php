<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="admin_comment")
     */
    public function index(CommentRepository $commentRepo): Response
    {
        return $this->render('admin/comment/admin_comment.html.twig', [
            'controller'      => 'COMMENTS',
            'comments'        => $commentRepo->findAll()
        ]);
    }

     /**
     * @Route("/admin/{id<[0-9]+>}/delete", name="admin_comment_delete", methods={"GET","POST"})
     */
    public function commentDelete(Comment $comment ,Request $request, EntityManagerInterface $manager)
    {
        $submittedToken = $request->request->get('_token');

        if($this->isCsrfTokenValid('secure_delete', $submittedToken))
        {
            $manager->remove($comment);
            $manager->flush();
        }
        return $this->redirectToRoute('admin_comment');
    }

     /**
     * @Route("/admin/{id<[0-9]+>}/erase", name="comment_erase", methods={"POST"})
     */
    public function erase(Comment $comment ,CommentRepository $commentRepo, EntityManagerInterface $manager)
    {
        try{
            $manager->remove($comment);
            $manager->flush();
            return new JsonResponse([
                'success' => true, 
                'view' =>  $this->renderView('admin/comment/comments_list.html.twig', [
                     'comments' => $commentRepo->findAll()
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
     * @Route("/admin/comment/{id<[0-9]+>}/album-delete", name="admin_album_comment_delete", methods={"GET","POST"})
     */
    public function albumCommentDelete(Comment $comment ,Request $request, EntityManagerInterface $manager)
    {
        $album          = $comment->getAlbum();
        $submittedToken = $request->request->get('_token');

        if($this->isCsrfTokenValid('secure_delete', $submittedToken))
        {
            $manager->remove($comment);
            $manager->flush();
        }

        return $this->redirectToRoute('admin_album_show', ['id' => $album->getId()]);
    }

     /**
     * @Route("/admin/{id<[0-9]+>}/album-erase", name="album_comment_erase", methods={"POST"})
     */
    public function albumCommentErase(Comment $comment ,CommentRepository $commentRepo, EntityManagerInterface $manager)
    {
        try{
            $manager->remove($comment);
            $manager->flush();
            return new JsonResponse([
                'success' => true, 
                'view' =>  $this->renderView('admin/album/comments_list.html.twig', [
                     'comments' => $commentRepo->findAll(),
                     'album'    =>$comment->getAlbum()
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
     * @Route("/admin/comment/{id<[0-9]+>}/image-delete", name="admin_image_comment_delete", methods={"GET","POST"})
     */
    public function imageCommentDelete(Comment $comment ,Request $request, EntityManagerInterface $manager)
    {
        $image          = $comment->getImage();
        $submittedToken = $request->request->get('_token');

        if($this->isCsrfTokenValid('secure_delete', $submittedToken))
        {
            $manager->remove($comment);
            $manager->flush();
        }

        return $this->redirectToRoute('admin_image_edit', ['id' => $image->getId()]);
    }

     /**
     * @Route("/admin/{id<[0-9]+>}/image-erase", name="image_comment_erase", methods={"POST"})
     */
    public function imageCommentErase(Comment $comment ,CommentRepository $commentRepo, EntityManagerInterface $manager)
    {
        try{
            $manager->remove($comment);
            $manager->flush();
            return new JsonResponse([
                'success' => true, 
                'view' =>  $this->renderView('admin/image/comments_list.html.twig', [
                     'comments' => $commentRepo->findAll(),
                     'image'    =>$comment->getImage()
                 ])
            ]);
        }catch(Exception $e){
            return new JsonResponse([
                'success' => false,
                'message' => $e->getMessage() 
                ]);
        }
    }
}
