<?php

$currenciesList = [
    ['name' => 'US Dollar', 'code' => 'USD', 'symbol' => '$', 'exchangeRate' => 1.0],
    ['name' => 'Euro', 'code' => 'EUR', 'symbol' => '€', 'exchangeRate' => 0.85],
    ['name' => 'British Pound', 'code' => 'GBP', 'symbol' => '£', 'exchangeRate' => 0.73],
    ['name' => 'Japanese Yen', 'code' => 'JPY', 'symbol' => '¥', 'exchangeRate' => 110.0],
    ['name' => 'Canadian Dollar', 'code' => 'CAD', 'symbol' => 'CA$', 'exchangeRate' => 1.25],
    ['name' => 'Swiss Franc', 'code' => 'CHF', 'symbol' => 'CHF', 'exchangeRate' => 0.92],
    ['name' => 'Chinese Yuan Renminbi', 'code' => 'CNY', 'symbol' => '¥', 'exchangeRate' => 6.45],
    ['name' => 'South Korean Won', 'code' => 'KRW', 'symbol' => '₩', 'exchangeRate' => 1200.0],
    ['name' => 'South African Rand', 'code' => 'ZAR', 'symbol' => 'R', 'exchangeRate' => 14.0],
    ['name' => 'Turkish Lira', 'code' => 'TRY', 'symbol' => '₺', 'exchangeRate' => 8.75],
    ['name' => 'Hong Kong Dollar', 'code' => 'HKD', 'symbol' => 'HK$', 'exchangeRate' => 7.80],
    ['name' => 'Singapore Dollar', 'code' => 'SGD', 'symbol' => 'S$', 'exchangeRate' => 1.33],
    ['name' => 'Saudi Riyal', 'code' => 'SAR', 'symbol' => '﷼', 'exchangeRate' => 3.75],
    ['name' => 'West African CFA Franc', 'code' => 'XOF', 'symbol' => 'CFA', 'exchangeRate' => 560.0],
    ['name' => 'Moroccan Dirham', 'code' => 'MAD', 'symbol' => 'MAD', 'exchangeRate' => 8.90],
];


$citiesData = [
    'Etats Unis' => [
        ['name' => 'New York', 'country' => 'Etats Unis'],
        ['name' => 'Los Angeles', 'country' => 'Etats Unis'],
        ['name' => 'San Francisco', 'country' => 'Etats Unis'],
        ['name' => 'Washington ', 'country' => 'Etats Unis'],
    ],
    'Angleterre' => [
        ['name' => 'London', 'country' => 'Angleterre'],
        ['name' => 'Birmingham', 'country' => 'Angleterre'],
        ['name' => 'Manchester', 'country' => 'Angleterre'],
        ['name' => 'Liverpool', 'country' => 'Angleterre'],
    ],
    'France' => [
        ['name' => 'Paris', 'country' => 'France'],
        ['name' => 'Marseille', 'country' => 'France'],
        ['name' => 'Lyon', 'country' => 'France'],
        ['name' => 'Toulouse', 'country' => 'France'],
        ['name' => 'Nice', 'country' => 'France'],
        ['name' => 'Nantes', 'country' => 'France'],
        ['name' => 'Strasbourg', 'country' => 'France'],
        ['name' => 'Montpellier', 'country' => 'France'],
        ['name' => 'Bordeaux', 'country' => 'France'],
        ['name' => 'Lille', 'country' => 'France'],
        ['name' => 'Rennes', 'country' => 'France'],
    ],
    'Senegal' => [
        ['name' => 'Dakar', 'country' => 'Senegal'],
        ['name' => 'Thiès', 'country' => 'Senegal'],
        ['name' => 'Saint-Louis', 'country' => 'Senegal'],
        ['name' => 'Rufisque', 'country' => 'Senegal'],
    
    ],
    'Mali' => [
        ['name' => 'Bamako', 'country' => 'Mali'],
        ['name' => 'Gao', 'country' => 'Mali'],
        ['name' => 'Tombouctou', 'country' => 'Mali'],
    ],
    'Italie' => [
        ['name' => 'Rome', 'country' => 'Italie'],
        ['name' => 'Milan', 'country' => 'Italie'],
        ['name' => 'Naples', 'country' => 'Italie'],
        ['name' => 'Turin', 'country' => 'Italie'],
    ],
    'Suisse' => [
        ['name' => 'Zurich', 'country' => 'Suisse'],
        ['name' => 'Geneva', 'country' => 'Suisse'],
    ],
    'Canada' => [
        ['name' => 'Toronto', 'country' => 'Canada'],
        ['name' => 'Montreal', 'country' => 'Canada'],
        ['name' => 'Vancouver', 'country' => 'Canada'],
        ['name' => 'Ottawa', 'country' => 'Canada'],
        ['name' => 'Quebec City', 'country' => 'Canada'],
        ['name' => 'Trois-Rivières', 'country' => 'Canada'],
        
    ],
    'Maroc' => [
        ['name' => 'Casablanca', 'country' => 'Maroc'],
        ['name' => 'Rabat', 'country' => 'Maroc'],
        ['name' => 'Fes', 'country' => 'Maroc'],
        ['name' => 'Marrakech', 'country' => 'Maroc'],
        ['name' => 'Tangier', 'country' => 'Maroc'],
        ['name' => 'Meknes', 'country' => 'Maroc'],
        ['name' => 'Kenitra', 'country' => 'Maroc'],  
    ],
    'Nigeria' => [
        ['name' => 'Lagos', 'country' => 'Nigeria'],
    ],
    'Côte d\'Ivoire' => [
        ['name' => 'Abidjan', 'country' => 'Côte d\'Ivoire'],
        ['name' => 'Bouaké', 'country' => 'Côte d\'Ivoire'],
        ['name' => 'Daloa', 'country' => 'Côte d\'Ivoire'],
        ['name' => 'Yamoussoukro', 'country' => 'Côte d\'Ivoire'],
    ],
    'Cameroun' => [
        ['name' => 'Yaoundé', 'country' => 'Cameroun'],
        ['name' => 'Douala', 'country' => 'Cameroun'],
        ['name' => 'Bafoussam', 'country' => 'Cameroun'],

    ],
    'Espagne' => [
        ['name' => 'Madrid', 'country' => 'Espagne'],
        ['name' => 'Barcelona', 'country' => 'Espagne'],
        ['name' => 'Valencia', 'country' => 'Espagne'],
    ],
    'Portugal' => [
        ['name' => 'Lisbon', 'country' => 'Portugal'],
    ],
    'Luxembourg' => [
        ['name' => 'Luxembourg', 'country' => 'Luxembourg'],
    ],
    'Benin' => [
        ['name' => 'Cotonou', 'country' => 'Benin'],
        ['name' => 'Porto-Novo', 'country' => 'Benin'],
    ],
    'Dubai' => [
        ['name' => 'Dubai', 'country' => 'Emirates arabes unis'],
    ],
    'Qatar' => [
        ['name' => 'Doha', 'country' => 'Qatar'],
    ],
    'Turquie' => [
        ['name' => 'Istanbul', 'country' => 'Turquie'],
    ],
    
    'Allemagne' => [
        ['name' => 'Berlin', 'country' => 'Allemagne'],
        ['name' => 'Munich', 'country' => 'Allemagne'],
    ],                      
    
];
?>
