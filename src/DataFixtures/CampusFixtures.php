<?php

namespace App\DataFixtures;

use App\DataFixtures\CityFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CampusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            \App\DataFixtures\CityFixtures::class,
        );
    }
}
