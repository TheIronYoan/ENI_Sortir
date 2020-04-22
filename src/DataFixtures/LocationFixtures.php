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
        //  Site localisation Campus Quimper

        $quimperLoc=new Location();
        $quimperLoc->setName('Site Quimper');
        $quimperLoc->setStreet('2 rue Georges Perros');
        $quimperLoc->setCity($manager->find(City::class,1));
        $manager->persist($quimperLoc);



        //  Site localisation Campus Quimper

        $nantesLoc=new Location();
        $nantesLoc->setName('Site Nantes');
        $nantesLoc->setStreet('2 rue Georges Prros');
        $nantesLoc->setCity($manager->find(City::class,2));
        $manager->persist($nantesLoc);


        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
