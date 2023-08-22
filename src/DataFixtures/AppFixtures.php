<?php

namespace App\DataFixtures;

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
        $cities = [];

        for ($i = 0; $i < 20; $i++) {
            $city = new City();
            $city->setName($faker->city);
            $city->setCountry($faker->country);

            $manager->persist($city);
            $cities[] = $city;
        }
        $manager->flush();

        /* CURRENCIES CREATION */
        $currenciesList = [
            ['name' => 'US Dollar', 'code' => 'USD', 'symbol' => '$', 'exchangeRate' => 1.0],
            ['name' => 'Euro', 'code' => 'EUR', 'symbol' => '€', 'exchangeRate' => 0.85],
            ['name' => 'British Pound', 'code' => 'GBP', 'symbol' => '£', 'exchangeRate' => 0.73],
            ['name' => 'Japanese Yen', 'code' => 'JPY', 'symbol' => '¥', 'exchangeRate' => 110.0],
            ['name' => 'Canadian Dollar', 'code' => 'CAD', 'symbol' => 'CA$', 'exchangeRate' => 1.25],
        ];
        
        $currencies = [];
        foreach ($currenciesList as $currencyData) {
            $currency = new Currency();
            $currency->setName($currencyData['name']);
            $currency->setCode($currencyData['code']);
            $currency->setSymbol($currencyData['symbol']);
            $currency->setExchangeRate($currencyData['exchangeRate']);

            if($currencyData['code'] == 'USD'){
                $currency->setIsDefault(true);
            }
            
            $manager->persist($currency);
            $currencies[] = $currency;
        }
        
        $manager->flush();

        /* ROOM CREATION */
        $users = [$user1, $user2, $user3];
        $conveyances = [$conveyance1, $conveyance2, $conveyance3];

        for ($i = 0; $i < 200; $i++) {
            $randomUserIndex = array_rand($users);
            $randomConveyanceIndex = array_rand($conveyances);
            $randomCityIndex = array_rand($cities);
            $randomCurrencyIndex = array_rand($currencies);

            $room = new Room();

            $room
                ->setName($faker->word)
                ->setCurrency($currencies[$randomCurrencyIndex])
                ->setUnitPrice($faker->numberBetween(1000, 5000))
                ->setWeight($faker->numberBetween(10, 100))
                ->setDepartureLocation($cities[$randomCityIndex])
                ->setArrivalLocation($cities[$randomCityIndex + 1] ?? $cities[0])
                ->setDepartureDate($faker->dateTimeBetween("-1 week", "+1 week"))
                ->setArrivalDate($faker->dateTimeBetween("+1 week", "+1 month"))
                ->setUser($users[$randomUserIndex])
                ->setConveyance($conveyances[$randomConveyanceIndex]);

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
