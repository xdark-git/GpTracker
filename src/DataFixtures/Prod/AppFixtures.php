<?php

namespace App\DataFixtures\Prod;

use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Viewpoint\AdminBundle\Traits\AdminTrait;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Viewpoint\ThemeBundle\Entity\City;
use Viewpoint\ThemeBundle\Entity\Currency;
use Viewpoint\ThemeBundle\Entity\Room;
use Viewpoint\ThemeBundle\Entity\RoomCellular;
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
        return ["prod"];
    }
    public function load(ObjectManager $manager): void
    {
        $roleAdmin = $this->createRole("ROLE_ADMIN");
        $roleUser = $this->createRole("ROLE_USER");
        $manager->persist($roleAdmin);
        $manager->persist($roleUser);
        $manager->flush();
    }
}
