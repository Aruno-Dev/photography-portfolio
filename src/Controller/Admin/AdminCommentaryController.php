<?php

namespace App\Controller\Admin;

use App\Entity\Commentary;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentaryController extends AbstractController
{
    /**
     * @Route("/admin/commentary", name="admin_commentary")
     */
    public function index()
    {
        return $this->render('admin_commentary/index.html.twig', [
            'controller_name' => 'AdminCommentaryController',
        ]);
    }

    /**
     * @Route("/admin/commentary/{id<[0-9]+>}/delete", name="admin_commentary_delete")
     */
    public function delete(Commentary $comment ,Request $request, EntityManagerInterface $manager)
    {
        $image = $comment->getImage();
        
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
