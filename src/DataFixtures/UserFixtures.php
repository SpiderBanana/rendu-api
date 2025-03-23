<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // Création d'un utilisateur Directeur
        $director = new User();
        $director->setEmail('director@example.com');
        $director->setNom('Directeur');
        $director->setPrenom('Test');
        // Attribuer le rôle de directeur
        $director->setRoles(['ROLE_DIRECTOR']);
        $hashedPassword = $this->passwordHasher->hashPassword($director, 'password');
        $director->setPassword($hashedPassword);
        $manager->persist($director);

        // Création d'un utilisateur Assistant vétérinaire
        $assistant = new User();
        $assistant->setEmail('assistant@example.com');
        $assistant->setNom('Assistant');
        $assistant->setPrenom('Vet');
        // Attribuer le rôle d'assistant vétérinaire
        $assistant->setRoles(['ROLE_ASSISTANT']);
        $hashedPassword = $this->passwordHasher->hashPassword($assistant, 'password');
        $assistant->setPassword($hashedPassword);
        $manager->persist($assistant);

        // Création d'un utilisateur Vétérinaire
        $veterinarian = new User();
        $veterinarian->setEmail('veterinarian@example.com');
        $veterinarian->setNom('Vétérinaire');
        $veterinarian->setPrenom('Vet');
        // Attribuer le rôle de vétérinaire
        $veterinarian->setRoles(['ROLE_VETERINARIAN']);
        $hashedPassword = $this->passwordHasher->hashPassword($veterinarian, 'password');
        $veterinarian->setPassword($hashedPassword);
        $manager->persist($veterinarian);

        $manager->flush();
    }
}
