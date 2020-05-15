<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;


class AdminImageController extends AbstractController
{
    /**
     * @Route("/admin/image", name="admin_image")
     */
    public function index(ImageRepository $images): Response
    {
        return $this->render('admin/image/admin_image.html.twig', [
            'controller_name' => 'AdminImageController',
            'images' =>$images->findAllDesc()
        ]);
    }

     /**
     * @Route("/admin/image/new", name="admin_image_new")
     */
    public function newImage(Request $request, EntityManagerInterface $manager, FileUploader $fileUploader)
    {

        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $imageFile = $form->get('file')->getData();

            if($imageFile) {
               
                $imageFileName = $fileUploader->upload($imageFile);
                $image->setFilename($imageFileName);
               

            }
            
            $manager->persist($image);
            $manager->flush();

            $this->addFlash('success', 'Image added successfully !');

            return $this->redirectToRoute('admin_image');
           

        }

        
        return $this->render('admin/image/new_image.html.twig', [
            'controller_name' => 'AdminImageController',
            'form'=> $form->createView()
        ]);
    }


    /**
    * @route("/admin/image/{id<[0-9]+>}/edit", methods={"GET", "POST", "PATCH"}, name="admin_image_edit")
    */
    public function editImage( Image $image, Request $request, EntityManagerInterface $manager)
    {
        
        $form = $this->createForm(ImageType::class, $image,['method' => 'PATCH']);
    
    //uniquement pour POST
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            
            $manager->persist($image);
            $manager->flush();

            $this->addFlash('success', 'Image updated successfully !');

            return $this->redirectToRoute('admin_image');
           

        }

        

        return $this->render('admin/image/edit_image.html.twig', [
            'controller_name' => 'AdminImageController',
            'image' => $image,
            'form' => $form->createView() 
        ]);

    }

    /**
     * @Route("/admin/image/{id<[0-9]+>}/delete", name="admin_image_delete", methods={"DELETE"})
     */
    public function deleteImage(Image $image, Request $request, EntityManagerInterface $manager)
    {
        $submittedToken = $request->request->get('_token');

        if($this->isCsrfTokenValid('secure_delete', $submittedToken))
        {
            $manager->remove($image);
            $manager->flush();

            $this->addFlash('success', 'Image deleted successfully !');
        }
   

        return $this->redirectToRoute('admin_image');

    }
}

