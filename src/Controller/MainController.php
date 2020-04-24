<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

/**
* Class UserController
* @Route("/register", name="register")
*/

    public function register(

        Request $request,
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $encoder,
        SluggerInterface $slugger
    )
    {
        $user = new User();
        $userForm = $this->createForm(RegisterType::class,$user);
        $userForm->handleRequest($request);
        if($userForm->isSubmitted() && $userForm->isValid()){
            $hashed=$encoder->encodePassword($user,$user->getPassword());
            $user->setIllustration($this->buildImage($userForm,$slugger));
            $user->setPassword($hashed);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success','Ajout réussi');
            return $this->redirectToRoute("login");
        }

        return $this->render('user/create.html.twig',[
            "userForm" =>$userForm->createView()
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
