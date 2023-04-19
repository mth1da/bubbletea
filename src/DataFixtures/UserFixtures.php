<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ){}

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setFirstName('Mathilde');
        $admin->setLastName('Turra');
        $admin->setEmail('mathilde@bbtea.com');
        $admin->setPassword($this->passwordHasher->hashPassword($admin,'admin'));
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        $user = new User();
        $user->setFirstName('Jane');
        $user->setLastName('Austen');
        $user->setEmail('jane@user.com');
        $user->setPassword($this->passwordHasher->hashPassword($user,'ackn0wledged'));
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);

        $manager->flush();

    }
}
