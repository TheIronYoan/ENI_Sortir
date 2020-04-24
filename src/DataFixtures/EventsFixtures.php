<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\EventState;
use App\Entity\Location;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EventsFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $events[]=['Deconfinement','1','2020-05-11 00:00:00','10','2020-05-10 00:00:00','1','1','10','Une sortie avec moi c\'est deja ca'];

        foreach ($events as $event) {

            $newEvent = new Event();
            $newEvent->setName($event[0]);
            $newEvent->setLocation($manager->find(Location::class,$event[1]));
            $format = 'Y-m-d H:i:s';
            $dateStart = \DateTime::createFromFormat($format, $event[2]);
            $newEvent->setStart($dateStart);
            $newEvent->setDuration((int)$event[3]);
            $dateLimit = \DateTime::createFromFormat($format, $event[4]);
            $newEvent->setSignInLimit($dateLimit);
            $newEvent->setState($manager->find(EventState::class,$event[5]));
            $newEvent->setOrganizer($manager->find(User::class,$event[6]));
            $newEvent->setMaxUsers($event[7]);

            $newEvent->setDescription($event[8]);


            $manager->persist($newEvent);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        return 6;
    }
}
