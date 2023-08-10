<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Viewpoint\AdminBundle\Traits\AdminTrait;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Viewpoint\ThemeBundle\Traits\ThemeTrait;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    use AdminTrait;
    use ThemeTrait;

    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getGroups(): array
    {
        return ["dev"];
    }
    public function load(ObjectManager $manager): void
    {
        $roleAdmin = $this->createRole("ROLE_ADMIN");
        $roleUser = $this->createRole("ROLE_USER");
        $manager->persist($roleAdmin);
        $manager->persist($roleUser);
        $manager->flush();

        $faker = Factory::create();

        $user1 = $this->createUser(
            email: "test@gmail.com",
            username: $faker->userName,
            password: "test",
            role: $roleAdmin,
            isVerified: true
        );
        $manager->persist($user1);
        $manager->flush();

        /* CONVEYANCE CREATION */
        $conveyance1 = $this->createConveyance("Avion");
        $conveyance2 = $this->createConveyance("Bateau");
        $conveyance3 = $this->createConveyance("Voiture");

        $manager->persist($conveyance1);
        $manager->persist($conveyance2);
        $manager->persist($conveyance3);
        $manager->flush();
        
    }
}
