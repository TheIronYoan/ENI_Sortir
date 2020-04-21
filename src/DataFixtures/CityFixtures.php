<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $cities=[
            29000 =>'Quimper',
            35131 =>'Chartres-de-Bretagne',
            44000 =>'Nantes',
            44390 =>'Nort-sur-Erdre',
            44800 =>'Saint-Herblain',
            49000 =>'Angers',
            53000 =>'Laval',
            72000 =>'Le Mans',
            79000 =>'Niort',
            85000 =>'La Roche-sur-Yon',
                ];

        foreach ($cities as $k => $v) {
            $newcity=new City();
            $newcity->setPostalCode($k);
            $newcity->setName($v);
            $manager->persist($newcity);
            $manager->flush();
        }





    }
}
