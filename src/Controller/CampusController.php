<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin", name="admin_")
 */
class CampusController extends AbstractController
{
    /**
     * @Route("/campus", name="campus")
     */
    public function index( Request $request,
                           EntityManagerInterface $em
                        )
    {


        $campus = new Campus();
        $campusForm = $this->createForm(CampusType::class,$campus);
        $campusForm->handleRequest($request);
        if($campusForm->isSubmitted()){
            $em->persist($campus);
            $em->flush();
            //return $this->redirectToRoute("index");
            return $this->redirectToRoute("home");
        }

        return $this->render('campus/index.html.twig',[
            "campusForm" =>$campusForm->createView()
        ]);
    }
    /**
     * @Route("/campus/list", name="campus_list")
     */
    public function listCampus( ){
        return $this->render('campus/index.html.twig');

    }

}
