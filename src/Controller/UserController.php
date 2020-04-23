<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\CheckPasswordType;
use App\Form\RegisterType;

use App\Form\RegisterTypetType;
use App\Form\UserInfoType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
    /**
     * Class UserController
     * @Route("/checkPassword", name="checkPassword")
     */
    public function checkPassword(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        SessionInterface $session
    )
    {
        $user = new User();
        $userForm = $this->createForm(CheckPasswordType::class,$user);
        $userForm->handleRequest($request);
        if($userForm->isSubmitted() && $userForm->isValid()){
            $checkPass = $encoder->isPasswordValid($this->getUser(), $user->getPassword());
            if ($checkPass===true) {
                $session->set("allowChange","true");
                return $this->redirectToRoute("user_changePassword");
            }else{
                $this->addFlash('danger','mot de passe incorrect');
                return $this->redirectToRoute("user_checkPassword");
            }
        }

        return $this->render('user/checkPassword.html.twig',[
            "userForm" =>$userForm->createView()
        ]);
    }
    /**
     * Class UserController
     * @Route("/changePassword", name="changePassword")
     */
    public function changePassword(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $encoder,
        SessionInterface $session
    )
    {   if ($session->get('allowChange')=='true') {
            $user = new User();
            $actualUser = $this->getUser();
            $userForm = $this->createForm(ChangePasswordType::class, $user);
            $userForm->handleRequest($request);
            if ($userForm->isSubmitted() && $userForm->isValid()) {
                $hashed = $encoder->encodePassword($user, $user->getPassword());
                $actualUser->setPassword($hashed);
                $em->persist($actualUser);
                $em->flush();
                $session->set("allowChange","false");
                $this->addFlash('success', 'modification réussi');
                return $this->redirectToRoute("user_show");
            }

            return $this->render('user/changePassword.html.twig', [
                "userForm" => $userForm->createView()
            ]);
        }else{
            return $this->redirectToRoute("user_checkPassword");
            }
    }
    /**
     * Class UserController
     * @Route("/viewAnotherInfo", name="viewAnotherInfo")
     */
    public function viewAnotherInfo(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $encoder
    )
    {
        $userToShow = new User();
        $userToShow->setUsername($request->get('username'));
        $userToShow->setFirstname($request->get('firstname'));
        $userToShow->setName($request->get('name'));
        $userToShow->setPhone($request->get('phone'));
        $userToShow->setEmail($request->get('email'));
        //mettre $request->get('campus') dans la méthode suivante quand les campus seront géré
        $userToShow->setCampus(null);
        return $this->render('user/viewAnotherUser.html.twig',[
            'userToShow'=> $userToShow
        ]);
    }
}
