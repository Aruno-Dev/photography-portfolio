<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\AlbumRepository;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\FileUploader;
use App\Service\ImageResizeService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AdminImageController extends AbstractController
{
    /**
     * @Route("/admin/image", name="admin_image")
     */
    public function index(ImageRepository $imageRepo, AlbumRepository $albums): Response
    {
        return $this->render('admin/image/admin_image.html.twig', [
            'controller'      => 'IMAGES',
            'images'          => $imageRepo->FindByAlbum(),
            'albums'          => $albums->findAll()
        ]);
    }

     /**
     * @Route("/admin/image/new", name="admin_image_new")
     */
    public function newImage(Request $request, EntityManagerInterface $manager, FileUploader $fileUploader, ImageResizeService $imageResize)
    {
        $image = new Image();
        $form  = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $imageFile = $form->get('file')->getData();
           
            if($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $image->setFilename($imageFileName);
            }
            $manager->persist($image);
            $manager->flush();

            $imageName          = $image->getFilename();
            $fullSizeImgWebPath = $fileUploader->getTargetDirectory().'/'.$imageName;
           [$width,$height]     = getimagesize($fullSizeImgWebPath);
            
            if($width > $height){
                $width  = 1500;
                $height =  1000;
            } else if($width == $height){
                $width  = 300;
                $height =  300;
            } else {  
                $width  = 1500;
                $height =  2254;
            }

            $imageResize->writeThumbnail($fullSizeImgWebPath, $width, $height);
            return $this->redirectToRoute('admin_image', ['controller' => 'IMAGES',]);
        }
        
        return $this->render('admin/image/new_image.html.twig', [
            'controller'      => 'IMAGES',
            'form'            => $form->createView()
        ]);
    }

    /**
    * @route("/admin/image/{id<[0-9]+>}/edit", methods={"GET", "POST", "PATCH"}, name="admin_image_edit")
    */
    public function editImage( Image $image, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ImageType::class, $image,['method' => 'PATCH']);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($image);
            $manager->flush();

            return $this->redirectToRoute('admin_image', ['controller' => 'IMAGES',]);
        }

        return $this->render('admin/image/edit_image.html.twig', [
            'controller'      => 'IMAGES',
            'image'           => $image,
            'form'            => $form->createView() 
        ]);
    }

    /**
     * @Route("/admin/image/{id<[0-9]+>}/delete", name="admin_image_delete", methods={"POST", "GET"})
     */
    public function deleteImage(Image $image, Request $request, EntityManagerInterface $manager)
    {
        $submittedToken = $request->request->get('_token');

        if($this->isCsrfTokenValid('secure_delete', $submittedToken))
        {
            $manager->remove($image);
            $manager->flush();
        }
        return $this->redirectToRoute('admin_image', ['controller' => 'IMAGES',]);
    }

    /**
     * @Route("/admin/image/{id<[0-9]+>}/erase", name="admin_image_erase", methods={"POST"})
     */
    public function eraseImage(Image $image, ImageRepository $imageRepo, EntityManagerInterface $manager)
    {
       try {
            $manager->remove($image);
            $manager->flush();
            return new JsonResponse([
                'success' => true, 
                'view'    =>  $this->renderView('admin/image/image_list.html.twig', [
                    'images' => $imageRepo->FindByAlbum(),
                ])
            ]);
       } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => $e->getMessage() 
                ]);
       }
    }

    /**
     * @Route("/admin/image/{id<[0-9]+>}/sort", name="admin_image_sort", methods={"POST"})
     */
    public function sort(Album $id, AlbumRepository $albumRepo)
    {
        $album = $albumRepo->find($id);
        $images = $album->getImages();
        return new JsonResponse([
            'success' => true, 
            'view'    =>  $this->renderView('admin/image/image_list.html.twig', [
                 'images'   => $images
             ])
        ]);
    }

     /**
     * @Route("/admin/image/sort-all", name="admin_image_all", methods={"POST"})
     */
    public function sortAll(ImageRepository $imageRepo)
    {
        return new JsonResponse([
            'success' => true, 
            'view'    =>  $this->renderView('admin/image/image_list.html.twig', [
                'images' => $imageRepo->FindByAlbum()
             ])
        ]);
    }
}

