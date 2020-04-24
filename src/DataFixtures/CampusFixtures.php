<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CampusFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $campus[]=['Quimper','1'];
        $campus[]=['Chartes de Bretagne','2'];
        $campus[]=['Nantes','3'];
        $campus[]=['Angers','4'];
        $campus[]=['Laval','1'];
        $campus[]=['Le Mans','5'];
        $campus[]=['Niort','6'];
        $campus[]=['La Roche-sur-Yon','1'];


        foreach ($campus as $campu) {
            $newCampus=new Campus();
            $newCampus->setName($campu[0]);
            $newCampus->setLocation($manager->find(Location::class,$campu[1]));
            $manager->persist($newCampus);
            $manager->flush();
        }

    }

    public function getOrder()
    {
        return 4;
    }
}
