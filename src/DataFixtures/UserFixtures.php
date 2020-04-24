<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        // Hash du password 1234
        $password='$argon2id$v=19$m=65536,t=4,p=1$d0hiV0NzOHlFMXdHVFVtZg$W3ZuXqaMaTmRMWHuRx/SCY3KGy2FjRzOUVCfh87/l0E';
        // Meme téléphone pour tout le monde
        $phone=0601020304;
        $users[]=['Bruno','HUDBERT','bruno@me.fr','bruno',false,'1'];
        $users[]=['Bruno','HUDBERT','bhudbert@ironcrew.site','bhudbert',true,'2'];
        $users[]=['Matthieu','GRELLIER','matthieu@me.fr','matthieu',false,'2'];
        $users[]=['Mélanie','DEPARIS','mdparis@me.fr','mdparis',false,'1'];
        $users[]=['Matthieu','GRELLIER','mgrellier@ironcrew.site','mgrellier',true,'3'];
        $users[]=['Alexandra','CASSANDRE','acassandre@me.fr','acassandre',false,'2'];
        $users[]=['Teddy','MARCHAND','teddy@me.fr','teddy',false,'3'];
        $users[]=['Lucie','DURAND','ldurand@me.fr','ldurand',false,'3'];
        $users[]=['Teddy','MARCHAND','tmarchand@ironcrew.site','tmarchand',true,'1'];
        $users[]=['Yoan','COTTREL','yoan@me.fr','yoan',false,'2'];
        $users[]=['Sébastien','DUPONT','sdupont@me.fr','sdupont',false,'1'];
        $users[]=['Aurelie','PETIT','apetit@me.fr','apetit',false,'4'];
        $users[]=['William','PANAM','wpanam@me.fr','wpanam',false,'2'];
        $users[]=['Yoan','COTTREL','ycottrel@ironcrew.site','ycottrel',true,'1'];
        $users[]=['Jérome','VENDOME','jvendome@me.fr','jvendome',false,'2'];
        $users[]=['Julien','JDUREE','jduree@me.fr','jduree',false,'4'];


        foreach ($users as $user) {
            $newUser = new User();
            $newUser->setFirstname($user[0]);
            $newUser->setName($user[1]);
            $newUser->setEmail($user[2]);
            $newUser->setPhone($phone);
            $newUser->setUsername($user[3]);
            $newUser->setAdministrator($user[4]);
            $newUser->setCampus($manager->find(Campus::class,$user[5]));
            $newUser->setPassword($password);
            $manager->persist($newUser);
            $manager->flush();
        }

    }


    public function getOrder()
    {
        return 5;
    }
}
