<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Admin;
use App\Entity\User;
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

//table user
        $admin = new User();
        $admin->setUsername('Admin');
        $admin->setPassword('admin');
        $encodedPassword = $this->passwordEncoder->encodePassword($admin, $admin->getPassword());
        $admin->setPassword($encodedPassword);

        $manager->persist($admin);
        $manager->flush();
    }
}
