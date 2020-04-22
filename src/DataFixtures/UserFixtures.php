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

        //  Utilisateur Bruno HUDBERT

        $bruno=new User();
        $bruno->setFirstname('Bruno');
        $bruno->setName('HUDBERT');
        $bruno->setEmail('bruno@me.fr');
        $bruno->setPhone($phone);
        $bruno->setUsername('bruno');
        $bruno->setAdministrator(false);
        $bruno->setPassword($password);
        $manager->persist($bruno);

        //  Administrateur Bruno HUDBERT

        $brunoAdmin=new User();
        $brunoAdmin->setFirstname('Bruno');
        $brunoAdmin->setName('HUDBERT');
        $brunoAdmin->setEmail('bruno@ironcrew.site');
        $brunoAdmin->setPhone($phone);
        $brunoAdmin->setUsername('bhudbert');
        $brunoAdmin->setAdministrator(true);
        $brunoAdmin->setPassword($password);
        $manager->persist($brunoAdmin);


        //  Utilisateur Matthieu GRELLIER

        $matthieu=new User();
        $matthieu->setFirstname('Matthieu');
        $matthieu->setName('GRELLIER');
        $matthieu->setEmail('matthieuo@me.fr');
        $matthieu->setPhone($phone);
        $matthieu->setUsername('matthieu');
        $matthieu->setAdministrator(false);
        $matthieu->setPassword($password);
        $manager->persist($matthieu);

        //  Administrateur Matthieu GRELLIER

        $matthieuAdmin=new User();
        $matthieuAdmin->setFirstname('Matthieu');
        $matthieuAdmin->setName('GRELLIER');
        $matthieuAdmin->setEmail('matthieu@ironcrew.site');
        $matthieuAdmin->setPhone($phone);
        $matthieuAdmin->setUsername('mgrellier');
        $matthieuAdmin->setAdministrator(true);
        $matthieuAdmin->setPassword($password);
        $manager->persist($matthieuAdmin);

        //  Utilisateur Yoan COTTREL

        $yoan=new User();
        $yoan->setFirstname('Yoan');
        $yoan->setName('COTTREL');
        $yoan->setEmail('matthieuo@me.fr');
        $yoan->setPhone($phone);
        $yoan->setUsername('yoan');
        $yoan->setAdministrator(false);
        $yoan->setPassword($password);
        $manager->persist($yoan);

        //  Administrateur  Yoan COTTREL

        $yoanAdmin=new User();
        $yoanAdmin->setFirstname('Yoan');
        $yoanAdmin->setName('COTTREL');
        $yoanAdmin->setEmail('yoan@ironcrew.site');
        $yoanAdmin->setPhone($phone);
        $yoanAdmin->setUsername('ycottrel');
        $yoanAdmin->setAdministrator(true);
        $yoanAdmin->setPassword($password);
        $manager->persist($yoanAdmin);

        //  Utilisateur Teddy MARCHAND

        $teddy=new User();
        $teddy->setFirstname('Teddy');
        $teddy->setName('MARCHAND');
        $teddy->setEmail('matthieuo@me.fr');
        $teddy->setPhone($phone);
        $teddy->setUsername('teddy');
        $teddy->setAdministrator(false);
        $teddy->setPassword($password);
        $manager->persist($teddy);

        //  Administrateur Teddy MARCHAND

        $teddyAdmin=new User();
        $teddyAdmin->setFirstname('Teddy');
        $teddyAdmin->setName('MARCHAND');
        $teddyAdmin->setEmail('teddy@ironcrew.site');
        $teddyAdmin->setPhone($phone);
        $teddyAdmin->setUsername('tmarchand');
        $teddyAdmin->setAdministrator(true);
        $teddyAdmin->setPassword($password);
        $manager->persist($teddyAdmin);


        $manager->flush();

    }


    public function getOrder()
    {
        return 5;
    }
}
