<?php

namespace App\Controller;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProjectsController extends AbstractController
{
    /**
     * @Route("/projects", name="projects")
     */
    public function index(ProjectRepository $projectRepo)
    {
        
        
        return $this->render('projects/index.html.twig', [
            'controller_name' => 'ProjectsController',
            'projects' => $projects = $projectRepo->findAll()
        ]);
    }

    /**
     
     * @Route("/projects/{id}", name="projects_show")
     */
    public function show(Project $project)
    {
        return $this->render('projects/show.html.twig',[
            'project' => $project
        ]);
    }
}
