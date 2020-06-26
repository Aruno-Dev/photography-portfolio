<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Entity\Image;
use App\Repository\AlbumRepository;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\AlbumType;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminAlbumController extends AbstractController
{
    /**
     * @Route("/admin/album", name="admin_album")
     */
    public function index(AlbumRepository $albums): Response
    {
        return $this->render('admin/album/admin_album.html.twig', [
            'controller'      => 'ALBUMS',
            'albums'          => $albums->FindAllDesc()
        ]);
    }

     /**
     * @Route("/admin/album/new", name="admin_album_new")
     */
    public function newAlbum(Request $request, EntityManagerInterface $manager)
    {
        $album = new Album();
        $form  = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($album);
            $manager->flush();

            return $this->redirectToRoute('admin_album');
        }
        return $this->render('admin/album/new_album.html.twig', [
            'controller'      => 'ALBUMS',
            'form'            => $form->createView()
        ]);
    }

    /**
    * @route("/admin/album/{id<[0-9]+>}/edit", methods={"GET", "POST", "PATCH"}, name="admin_album_edit")
    */
    public function editAlbum( Album $album, Request $request, EntityManagerInterface $manager, FileUploader $fileUploader)
    {
        $form = $this->createForm(AlbumType::class, $album,['method' => 'PATCH']);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($album);
            $manager->flush();

            return $this->redirectToRoute('admin_album_show', ['id' => $album->getId()]);
        }

        return $this->render('admin/album/edit_album.html.twig', [
            'controller'      => 'ALBUMS',
            'album'           => $album,
            'form'            => $form->createView() 
        ]);
    }

    /**
     * @Route("/admin/album/{id<[0-9]+>}/delete", name="admin_album_delete", methods={"GET", "POST"})
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
            
        }
        return $this->redirectToRoute('admin_album');
    }

    /**
     * @Route("/admin/album/{id<[0-9]+>}/erase", name="admin_album_erase", methods={"POST"})
     */
    public function eraseAlbum(Album $album, AlbumRepository $albumRepo, EntityManagerInterface $manager)
    {
       try{
            $images = $album->getImages();
            foreach($images as $image){
                $image->setAlbum(null);
            }
            $manager->remove($album);
            $manager->flush();
            return new JsonResponse([
                'success' => true, 
                'view'    =>  $this->renderView('admin/album/album_list.html.twig', [
                    'albums'    =>$albumRepo->FindAllDesc()
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
     * @Route("/admin/album/{id<[0-9]+>}/show", name="admin_album_show")
     */
    public function show(Album $album)
    {
        $images = $album->getImages();
        return $this->render('admin/album/show_album.html.twig',[
            'controller'      => 'ALBUMS',
            'album'           => $album,
            'images'          => $images
        ]);
    }

    /**
     * @Route("/admin/album/{id<[0-9]+>}/choose-image", name="admin_album_choose_image")
     */
    public function chooseImage(Album $album, ImageRepository $images)
    {
        return $this->render('admin/album/choose_image_album.html.twig',[
            'controller'      => 'ALBUMS',
            'album'           => $album,
            'images'          => $images->FindAllDesc()
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
       if($album->getCover() == $image->getFilename()){
            $album->setCover(null);
       }
      
       $image->setAlbum(null);
       $manager->flush();
     
       return $this->redirectToRoute('admin_album_show', ['id' => $id, 'controller' => 'ALBUMS',]);
    }

    /**
     * @Route("/admin/album/{id<[0-9]+>}/set-cover", name="admin_album_set_cover")
     */
    public function setAsCover(Image $image, EntityManagerInterface $manager)
    {
       $album = $image->getAlbum();
       $album->setCover($image->getFilename());
       $manager->flush();
     
       return $this->redirectToRoute('admin_album', ['controller' => 'ALBUMS',]);
    }
}
