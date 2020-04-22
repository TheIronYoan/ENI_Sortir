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

        $quimperCampus=new Campus();
        $quimperCampus->setName('Campus de Quimper');
        $quimperCampus->setLocation($manager->find(Location::class,1));

        $manager->persist($quimperCampus);

        $manager->flush();


    }

    public function getOrder()
    {
        return 3;
    }
}
