<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Viewpoint\AdminBundle\Traits\AdminTrait;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Viewpoint\ThemeBundle\Entity\City;
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
            username: "gpadmin1",
            password: "test",
            role: $roleAdmin,
            isVerified: true
        );
        $user2 = $this->createUser(
            email: $faker->email,
            username: "gpadmin2",
            password: "test",
            role: $roleAdmin,
            isVerified: true
        );
        $user3 = $this->createUser(
            email: $faker->email,
            username: "gpadmin3",
            password: "test",
            role: $roleAdmin,
            isVerified: true
        );
        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->flush();

        /* CONVEYANCE CREATION */
        $conveyance1 = $this->createConveyance("Avion");
        $conveyance2 = $this->createConveyance("Bateau");
        $conveyance3 = $this->createConveyance("Voiture");

        $manager->persist($conveyance1);
        $manager->persist($conveyance2);
        $manager->persist($conveyance3);
        $manager->flush();

        /* CITIES CREATION */
        $city1 = new City();
        $city2 = new City();

        $city1->setName("Dakar")->setCountry("Senegal");
        $city2->setName("Paris")->setCountry("France");
        $manager->persist($city1);
        $manager->persist($city2);
        $manager->flush();

        /* ROOM CREATION */
        $users = [$user1, $user2, $user3];
        $conveyances = [$conveyance1, $conveyance2, $conveyance3];

        for ($i = 0; $i < 200; $i++) {
            $randomUser = array_rand($users);
            $randomConveyance = array_rand($conveyances);

            $room = new Room();

            $room
                ->setName($faker->word)
                ->setCurrency("XOF")
                ->setUnitPrice($faker->numberBetween(1000, 5000))
                ->setWeight($faker->numberBetween(10, 100))
                ->setDepartureLocation($city1)
                ->setArrivalLocation($city2)
                ->setDepartureDate($faker->dateTimeBetween("now", "+1 week"))
                ->setArrivalDate($faker->dateTimeBetween("+1 week", "+1 month"))
                ->setUser($users[$randomUser])
                ->setConveyance($conveyances[$randomConveyance]);
            
            $cellular = new RoomCellular();
            $cellular
                ->setPrimary($faker->phoneNumber)
                ->setSecondary($faker->phoneNumber)
                ->setRoom($room);

            $manager->persist($room);
            $manager->persist($cellular);
            $manager->flush();
        }
    }
}
