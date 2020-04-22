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

        $campus=new Campus();
        $campus->setName('Campus de Quimper');
        $campus->setLocation($manager->find(Location::class,1));

        $manager->persist($campus);

        $manager->flush();


    }

    public function getOrder()
    {
        return 3;
    }
}
