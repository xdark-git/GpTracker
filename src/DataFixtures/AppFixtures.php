<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Viewpoint\AdminBundle\Traits\AdminTrait;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    use AdminTrait;

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
        
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $roleAdmin = $this->createRole("ROLE_ADMIN");
        $roleUser = $this->createRole("ROLE_USER");
        $manager->persist($roleAdmin);
        $manager->persist($roleUser);
        $manager->flush();

        $faker = Factory::create();
        
        $user1 = $this->createUser(email: $faker->email, username: $faker->userName, password: "test", role: $roleAdmin);
        $manager->persist($user1);
        $manager->flush();
    }
}
