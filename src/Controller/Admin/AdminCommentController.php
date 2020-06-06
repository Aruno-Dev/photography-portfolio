<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            'controller_name' => 'AdminCommentController',
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

            $this->addFlash('success', 'comment deleted successfully !');
           
        }

        return $this->redirectToRoute('admin_comment');
    }

    /**
     * @Route("/admin/comment/{id<[0-9]+>}/album-delete", name="admin_album_comment_delete", methods={"GET","POST"})
     */
    public function albumDelete(Comment $comment ,Request $request, EntityManagerInterface $manager)
    {
        $album          = $comment->getAlbum();
        $submittedToken = $request->request->get('_token');

        if($this->isCsrfTokenValid('secure_delete', $submittedToken))
        {
            $manager->remove($comment);
            $manager->flush();

            $this->addFlash('success', 'comment deleted successfully !');
        }

        return $this->redirectToRoute('admin_album_show', ['id' => $album->getId()]);
    }

     /**
     * @Route("/admin/comment/{id<[0-9]+>}/image-delete", name="admin_image_comment_delete", methods={"GET","POST"})
     */
    public function imageDelete(Comment $comment ,Request $request, EntityManagerInterface $manager)
    {
        $image          = $comment->getImage();
        $submittedToken = $request->request->get('_token');

        if($this->isCsrfTokenValid('secure_delete', $submittedToken))
        {
            $manager->remove($comment);
            $manager->flush();

            $this->addFlash('success', 'comment deleted successfully !');
        }

        return $this->redirectToRoute('admin_image_edit', ['id' => $image->getId()]);
    }
}
