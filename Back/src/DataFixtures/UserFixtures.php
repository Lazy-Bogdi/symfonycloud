<?php

// declare(strict_types=1);
namespace App\DataFixtures;


namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $adminUser = new User();
        $adminUser->setEmail('admin@admin.com');
        $password = $this->passwordHasher->hashPassword($adminUser, 'admin');
        $adminUser->setPassword($password);
        $adminUser->setRoles(['ROLE_ADMIN']);

        $casualUser = new User();
        $casualUser->setEmail('casual@casual.com');
        $password = $this->passwordHasher->hashPassword($casualUser, 'casual');
        $casualUser->setPassword($password);
        $casualUser->setRoles(['ROLE_USER']);

        $manager->persist($adminUser);
        $manager->persist($casualUser);
        $manager->flush();
    }
}

