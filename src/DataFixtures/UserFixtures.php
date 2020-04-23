<?php

namespace App\DataFixtures;

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
        $users[]=['Bruno','HUDBERT','bruno@me.fr','bruno',false];
        $users[]=['Bruno','HUDBERT','bhudbert@ironcrew.site','bhudbert',true];



        //  Utilisateur Bruno HUDBERT
        foreach ($users as $user) {
            $newUser = new User();
            $newUser->setFirstname($user[0]);
            $newUser->setName($user[1]);
            $newUser->setEmail($user[2]);
            $newUser->setPhone($phone);
            $newUser->setUsername($user[3]);
            $newUser->setAdministrator($user[4]);
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
