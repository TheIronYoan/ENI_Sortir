<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;

use App\Form\RegisterTypetType;
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

    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * Class UserController
     * @Route("/add", name="add")
     */

    public function create(

                        Request $request,
                        EntityManagerInterface $em,
                        UserPasswordEncoderInterface $encoder
                    )
        {
            $user = new User();
            $userForm = $this->createForm(RegisterType::class,$user);
            $userForm->handleRequest($request);
            if($userForm->isSubmitted() && $userForm->isValid()){
                $hashed=$encoder->encodePassword($user,$user->getPassword());
                $user->setPassword($hashed);
            $em->persist($user);
            $em->flush();
                $this->addFlash('success','Ajout réussi');
            return $this->redirectToRoute("user_add");
            }

        return $this->render('user/create.html.twig',[
            "userForm" =>$userForm->createView()
        ]);
    }
}
