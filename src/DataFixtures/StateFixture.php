<?php

namespace App\DataFixtures;

use App\Entity\EventState;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StateFixture extends Fixture  implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $eventStates=['Créée','Ouverte','Cloturée','Annulée'];

        foreach ($eventStates as $eventState) {
            $newState=new EventState();
            $newState->setLabel($eventState);
            $manager->persist($newState);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        return 2;
    }
}
