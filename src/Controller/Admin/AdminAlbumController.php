<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Entity\Image;
use App\Repository\AlbumRepository;
use App\Form\AlbumType;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\FileUploader;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;

class AdminAlbumController extends AbstractController
{
    /**
     * @Route("/admin/album", name="admin_album")
     */
    public function index(AlbumRepository $albums): Response
    {
        return $this->render('admin/album/admin_album.html.twig', [
            'controller_name' => 'AdminAlbumController',
            'albums' => $albums->FindAllDesc()
            
        ]);
    }


     /**
     * @Route("/admin/album/new", name="admin_album_new")
     */
    public function newAlbum(Request $request, EntityManagerInterface $manager)
    {

        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($album);
            $manager->flush();

            $this->addFlash('success', 'Album added successfully !');
            

            return $this->redirectToRoute('admin_album');

        }
        return $this->render('admin/album/new_album.html.twig', [
            'controller_name' => 'AdminAlbumController',
            'form'=> $form->createView()
        ]);
    }

    /**
    * @route("/admin/album/{id<[0-9]+>}/edit", methods={"GET", "POST", "PATCH"}, name="admin_album_edit")
    */
    public function editAlbum( Album $album, Request $request, EntityManagerInterface $manager, FileUploader $fileUploader)
    {
        
        $form = $this->createForm(AlbumType::class, $album,['method' => 'PATCH']);
    
    //uniquement pour POST
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($album);
            $manager->flush();

            $this->addFlash('success', 'Album updated successfully !');

            return $this->redirectToRoute('admin_album_show', ['id' => $album->getId()]);

        }

        return $this->render('admin/album/edit_album.html.twig', [
            'controller_name' => 'AdminAlbumController',
            'album' => $album,
            'form' => $form->createView() 
        ]);

    }

    /**
     * @Route("/admin/album/{id<[0-9]+>}/delete", name="admin_album_delete", methods={"DELETE"})
     */
    public function deleteAlbum(Album $album, Request $request, EntityManagerInterface $manager)
    {
        $submittedToken = $request->request->get('_token');

        if($this->isCsrfTokenValid('secure_delete', $submittedToken))
        {
            $images = $album->getImages();
            foreach($images as $image){
                
                $image->setAlbum(null);

            }
            
            $manager->remove($album);
            $manager->flush();

            $this->addFlash('success', 'Album deleted successfully !');
        }
   

        return $this->redirectToRoute('admin_album');

    }

    

     /**
     * @Route("/admin/album/{id<[0-9]+>}/show", name="admin_album_show")
     */
    public function show(Album $album)
    {
        $images = $album->getImages();
        return $this->render('admin/album/show_album.html.twig',[
            'controller_name' => 'AdminAlbumController',
            'album' => $album,
            'images' => $images
        ]);
    }

    /**
     * @Route("/admin/album/{id<[0-9]+>}/choose-image", name="admin_album_choose_image")
     */
    public function chooseImage(Album $album, ImageRepository $images)
    {
        return $this->render('admin/album/choose_image_album.html.twig',[
            'controller_name' => 'AdminAlbumController',
            'album' => $album,
            'images' => $images->FindAllDesc()
        ]);
    }


    /**
     * @Route("/admin/album/{album<[0-9]+>}/add-image/{id<[0-9]+>}", name="admin_album_add_image")
     */
    public function addImage(Image $image, Album $album, EntityManagerInterface $manager)
    {
       
        $image->setAlbum($album);
        $manager->flush();
        

        return $this->redirectToRoute('admin_album_show', ['id' => $album->getId()]);


        
    }


    /**
     * @Route("/admin/album/{album<[0-9]+>}/remove/{id<[0-9]+>}", name="admin_album_remove")
     */
    public function remove(Image $image, Album $album, EntityManagerInterface $manager)
    {

       $id = $album->getId();
       $album->setCover(null);
       $image->setAlbum(null);
       $manager->flush();
     
       return $this->redirectToRoute('admin_album_show', ['id' => $id]);
    }



    /**
     * @Route("/admin/album/{id<[0-9]+>}/set-cover", name="admin_album_set_cover")
     */
    public function setAsCover(Image $image, EntityManagerInterface $manager)
    {
        
       $album = $image->getAlbum();
       $album->setCover($image->getFilename());
       
       $manager->flush();
     
       return $this->redirectToRoute('admin_album');
    }

    


}
