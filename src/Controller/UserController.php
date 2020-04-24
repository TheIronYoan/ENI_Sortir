<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\CheckPasswordType;
use App\Form\RegisterType;


use App\Form\EditUserType;
use App\Form\UserInfoType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


class UserController extends AbstractController
{

    /**
     * @var UserRepository
     */

    private $repository;

    /**
     * @var ObjectManager
     */

    private $em;
    public function __construct(UserRepository $repository,EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }



    /**
     * Class UserController
     * @Route("/user/index", name="user_index")
     */

    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * Class UserController
     * @Route("/user/usershow", name="user_show")
     */
    public function showInfo(
                        Request $request,
                        EntityManagerInterface $em,
                        UserPasswordEncoderInterface $encoder,
                        SluggerInterface $slugger
                        )
    {
        $user= $this->getUser();
        $userForm = $this->createForm(UserInfoType::class,$user);
        $userForm->handleRequest($request);
         if($userForm->isSubmitted() && $userForm->isValid()){
             //Illustration
             $user->setIllustration($this->buildImage($userForm,$slugger));

             $hashed=$encoder->encodePassword($user,$user->getPassword());
             $user->setPassword($hashed);
             $em->persist($user);
             $em->flush();
             $this->addFlash('success','modification réussi');
             return $this->redirectToRoute("user_show");
         }

        return $this->render('user/showUserInfo.html.twig',[
            "userForm" =>$userForm->createView(),
            "user" => $user
        ]);
    }
    /**
     * Class UserController
     * @Route("/checkPassword", name="user_checkPassword")
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
     * @Route("/changePassword", name="user_changePassword")
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
     * @Route("/viewAnotherInfo", name="user_viewAnotherInfo")
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
        $userToShow->setIllustration($request->get('image'));
        //mettre $request->get('campus') dans la méthode suivante quand les campus seront géré
        $userToShow->setCampus(null);
        return $this->render('user/viewAnotherUser.html.twig',[
            'userToShow'=> $userToShow
        ]);
    }


    /**
     * Class UserController
     * @Route("/admin/user/edit/{id<\d+>?0}", name="admin_user_edit")
     */
    public function edit(
        $id,
        Request $request,
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $encoder
    )
    {
        if($id==0) {
        $user = new User();
    }
    else{
        $user= $this->repository->find($id);
    }
        $userForm = $this->createForm(EditUserType::class,$user);
        $userForm->handleRequest($request);
        if($userForm->isSubmitted() && $userForm->isValid()){
            $hashed=$encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hashed);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success','Ajout réussi');
            return $this->redirectToRoute("admin_user_list");
        }

        return $this->render('user/showUserInfo.html.twig',[
            "userForm" =>$userForm->createView()
        ]);


    }
    /**
     * Class UserController
     * @Route("/admin/user/list/", name="admin_user_list")
     */
    public function list( Request $request){

        $users = $this->repository->findAll();
        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);


    }


    public function buildImage( $userform,SluggerInterface $slugger){
        $illustrationFile = $userform->get('illustration')->getData();
        if($illustrationFile!=null){
            $originalFilename = pathinfo($illustrationFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$illustrationFile->guessExtension();
            try {
                $illustrationFile->move(
                    $this->getParameter('illustration_directory'),
                    $newFilename
                );

            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
        }
        return $newFilename;
    }
}
