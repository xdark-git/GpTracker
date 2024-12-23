<?php

namespace App\DataFixtures\Prod;

use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Viewpoint\AdminBundle\Traits\AdminTrait;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Viewpoint\ThemeBundle\Entity\City;
use Viewpoint\ThemeBundle\Entity\Conveyance;
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

        $cities = $this->getCitiesList();

        foreach ($cities as $cityData) {
            $city = (new City())->setName($cityData["name"])->setCountry($cityData["country"]);
            $manager->persist($city);
        }
        $manager->flush();

        $currencies = $this->getCurrenciesList();

        foreach ($currencies as $currencyData) {
            $currency = (new Currency())
                ->setName($currencyData["name"])
                ->setCode($currencyData["code"])
                ->setSymbol($currencyData["symbol"])
                ->setExchangeRate($currencyData["exchangeRate"]);

            $manager->persist($currency);
        }
        $manager->flush();

        $conveyances = ["Avion", "Bateau", "Voiture"];

        foreach ($conveyances as $conveyanceData) {
            $conveyance = (new Conveyance())->setName($conveyanceData);

            $manager->persist($conveyance);
        }
        $manager->flush();
    }

    private function getCitiesList(): array
    {
        $citiesData = [
            ["name" => "New York", "country" => "Etats Unis"],
            ["name" => "Los Angeles", "country" => "Etats Unis"],
            ["name" => "San Francisco", "country" => "Etats Unis"],
            ["name" => "Washington ", "country" => "Etats Unis"],
            ["name" => "London", "country" => "Angleterre"],
            ["name" => "Manchester", "country" => "Angleterre"],
            ["name" => "Liverpool", "country" => "Angleterre"],
            ["name" => "Paris", "country" => "France"],
            ["name" => "Marseille", "country" => "France"],
            ["name" => "Lyon", "country" => "France"],
            ["name" => "Toulouse", "country" => "France"],
            ["name" => "Nice", "country" => "France"],
            ["name" => "Nantes", "country" => "France"],
            ["name" => "Strasbourg", "country" => "France"],
            ["name" => "Montpellier", "country" => "France"],
            ["name" => "Bordeaux", "country" => "France"],
            ["name" => "Lille", "country" => "France"],
            ["name" => "Rennes", "country" => "France"],
            ["name" => "Dakar", "country" => "Senegal"],
            ["name" => "Thiès", "country" => "Senegal"],
            ["name" => "Saint-Louis", "country" => "Senegal"],
            ["name" => "Rufisque", "country" => "Senegal"],
            ["name" => "Bamako", "country" => "Mali"],
            ["name" => "Gao", "country" => "Mali"],
            ["name" => "Tombouctou", "country" => "Mali"],
            ["name" => "Rome", "country" => "Italie"],
            ["name" => "Milan", "country" => "Italie"],
            ["name" => "Naples", "country" => "Italie"],
            ["name" => "Turin", "country" => "Italie"],
            ["name" => "Zurich", "country" => "Suisse"],
            ["name" => "Geneva", "country" => "Suisse"],
            ["name" => "Toronto", "country" => "Canada"],
            ["name" => "Montreal", "country" => "Canada"],
            ["name" => "Ottawa", "country" => "Canada"],
            ["name" => "Quebec City", "country" => "Canada"],
            ["name" => "Trois-Rivières", "country" => "Canada"],
            ["name" => "Casablanca", "country" => "Maroc"],
            ["name" => "Rabat", "country" => "Maroc"],
            ["name" => "Fes", "country" => "Maroc"],
            ["name" => "Marrakech", "country" => "Maroc"],
            ["name" => "Tangier", "country" => "Maroc"],
            ["name" => "Meknes", "country" => "Maroc"],
            ["name" => "Kenitra", "country" => "Maroc"],
            ["name" => "Abidjan", "country" => "Côte d'Ivoire"],
            ["name" => "Yamoussoukro", "country" => "Côte d'Ivoire"],
            ["name" => "Yaoundé", "country" => "Cameroun"],
            ["name" => "Douala", "country" => "Cameroun"],
            ["name" => "Bafoussam", "country" => "Cameroun"],
            ["name" => "Madrid", "country" => "Espagne"],
            ["name" => "Barcelona", "country" => "Espagne"],
            ["name" => "Istanbul", "country" => "Turquie"],
            ["name" => "Berlin", "country" => "Allemagne"],
            ["name" => "Munich", "country" => "Allemagne"],
        ];

        return $citiesData;
    }

    private function getCurrenciesList(): array
    {
        $currenciesList = [
            ["name" => "US Dollar", "code" => "USD", "symbol" => '$', "exchangeRate" => 1.0],
            ["name" => "Euro", "code" => "EUR", "symbol" => "€", "exchangeRate" => 0.85],
            ["name" => "British Pound", "code" => "GBP", "symbol" => "£", "exchangeRate" => 0.73],
            [
                "name" => "Canadian Dollar",
                "code" => "CAD",
                "symbol" => 'CA$',
                "exchangeRate" => 1.25,
            ],
            ["name" => "Turkish Lira", "code" => "TRY", "symbol" => "₺", "exchangeRate" => 8.75],
            [
                "name" => "West African CFA Franc",
                "code" => "XOF",
                "symbol" => "CFA",
                "exchangeRate" => 560.0,
            ],
            [
                "name" => "Moroccan Dirham",
                "code" => "MAD",
                "symbol" => "MAD",
                "exchangeRate" => 8.9,
            ],
        ];
        return $currenciesList;
    }
}
