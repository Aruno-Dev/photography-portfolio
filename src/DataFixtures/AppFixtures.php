<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
           $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {

//table admin
        $admin = new Admin();
        $admin->setUsername('Admin');
        $admin->setPassword('admin');
        $encodedPassword = $this->passwordEncoder->encodePassword($admin, $admin->getPassword());
        $admin->setPassword($encodedPassword);

        $manager->persist($admin);

//table project
        for ($i = 0; $i < 12; $i++) { 
            $project = new Project();
            $project->setTitle('My project title')
                    ->setIntroduction('Ceci est mon premier projet Symfony 4 !')
                    ->setDescription("Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte.")
                    ->setImage('public\images\project1.JPG');

                $manager->persist($project);
            }
            


        $manager->flush();
    }
}
