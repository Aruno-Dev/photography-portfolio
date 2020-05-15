<?php
namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  @route("/admin/project")
 */
class AdminProjectController extends AbstractController
{

    /**
     * @route("s", name="list")
     */
    public function projects(ProjectRepository $projectsRepo)
    {
        return $this->render('admin/projects/list.html.twig', [
            'projects' => $projectsRepo->findAll()
        ]);
    }

    /**
     * @route("/new", name="admin_projects_new")
     */
    public function new(Request $request, EntityManagerInterface $manager)
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($project);
            $manager->flush();

            return $this->redirectToRoute('list');
          

        }

        return $this->render('admin/projects/new.html.twig',[
    'form'=> $form->createView()],);
    }


    /**
     * @route("/{id}/delete", name="admin_projects_delete")
     */

    public function delete(Project $project, EntityManagerInterface $manager)
    {
        $manager->remove($project);
        $manager->flush();
        return $this->redirectToRoute('list',[
            'project' => $project
        ]);
    }

    

     /**
     *  @route("/{id}/edit", name="admin_projects_edit")
     */
    public function edit(Request $request, Project $project, EntityManagerInterface $manager)
    {
       $form = $this->createForm(ProjectType::class, $project);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
           $manager->persist($project);
           $manager->flush();

           return $this->redirectToRoute('list');
         

       }
        return $this->render('admin/projects/edit.html.twig',[
            'form' => $form->createView(),
            'project' => $project
        ]);
    }
}
