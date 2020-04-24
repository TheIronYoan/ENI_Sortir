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
        $events[]=['Revision en groupe','1','2020-05-11 00:00:00','10','2020-05-01 00:00:00','4','2','10','Sortie revision car Symfony c\'est pas si simple'];
        $events[]=['Forum emploi','1','2020-05-11 00:00:00','10','2020-04-28 00:00:00','4','2','10','Venez rencontrer votre futur employeur ou futur entreprise de stage'];

        $events[]=['Deconfinement','1','2020-05-11 00:00:00','10','2020-05-10 00:00:00','2','2','10','Pouvoir sor c\'est deja pas si mal'];
        $events[]=['Sortie Ski','3','2020-05-08 00:00:00','10','2020-05-10 00:00:00','2','14','10','Faire du ski ici et en ce moment c\'est forcement proposé par Yoan'];
        $events[]=['Terre cuite','3','2020-05-08 00:00:00','10','2020-05-10 00:00:00','2','14','10','Visite des statuts de terre cuite , guidée par Yoan'];
        $events[]=['Festival','1','2020-06-27 00:00:00','10','2020-05-10 00:00:00','2','9','1000','Plein de gens font du bruit , y en a meme qui fonc de la musique'];
        $events[]=['Plage Normandie','2','2020-06-16 00:00:00','10','2020-06-01 00:00:00','2','3','100','La sortie pour se se souvenir et se rendre compte'];
        $events[]=['Sortie Zenith','3','2021-01-11 00:00:00','10','2020-05-10 00:00:00','2','3','10','Il finira bien par y avoir des concerts a nouveau un jour'];
        $events[]=['Sortie Plage','10','2020-07-13 00:00:00','10','2020-05-10 00:00:00','3','14','10','Si vous n\'avez pas de stage , venez nous rejoindre a la plage'];

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
