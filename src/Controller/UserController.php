<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;

use App\Form\RegisterTypetType;
use App\Form\UserInfoType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @Route("/user" , name="user_")
 */
class UserController extends AbstractController
{


    /**
     * Class UserController
     * @Route("/index", name="index")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


    /**
     * Class UserController
     * @Route("/show", name="show")
     */
    public function showInfo(
                        Request $request,
                        EntityManagerInterface $em,
                        UserPasswordEncoderInterface $encoder
                        )
    {
        $user= $this->getUser();
        $userForm = $this->createForm(UserInfoType::class,$user);
        $userForm->handleRequest($request);
         if($userForm->isSubmitted() && $userForm->isValid()){
             $hashed=$encoder->encodePassword($user,$user->getPassword());
             $user->setPassword($hashed);
             $em->persist($user);
             $em->flush();
             $this->addFlash('success','modification réussi');
             return $this->redirectToRoute("user_show");
         }

        return $this->render('user/showUserInfo.html.twig',[
            "userForm" =>$userForm->createView()
        ]);
    }
}
