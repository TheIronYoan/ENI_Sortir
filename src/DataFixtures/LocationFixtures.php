<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $locations[]=['Eni Quimper','2 rue Georges Perros','','1'];
        $locations[]=['Eni Chartes De Bretagne','8 rue Léo Lagrange ',' ZAC de la Conterie','2'];
        $locations[]=['Eni Nantes','22 B rue Benjamin Franklin','ZAC du Moulin Neuf','5'];
        $locations[]=['Eni Angers','6 rue Guillaume Lekeu','','6'];
        $locations[]=['Eni Laval','8 rue de la commanderie ','','7'];
        $locations[]=['Eni Le Mans','366 Avenue Georges Durand','','8'];
        $locations[]=['Eni Niort','2 rue Georges Perros','','9'];
        $locations[]=['Eni La Roche-sur-Yon','12 impasse Ampère ','','10'];


        foreach ($locations as $location) {
            $newLocations=new Location();
            $newLocations->setName($location[0]);
            $newLocations->setStreet($location[1]);
            $newLocations->setAddrComplement($location[2]);
            $newLocations->setCity($manager->find(City::class,$location[3]));
            $manager->persist($newLocations);

            $manager->flush();
        }


    }

    public function getOrder()
    {
        return 3;
    }
}
