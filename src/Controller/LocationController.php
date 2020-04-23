<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\InsertLocationType;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user_")
 */

class LocationController extends AbstractController
{
    /**
     * @var CityRepository
     */

    private $repository;

    /**
     * @var ObjectManager
     */

    private $em;
    public function __construct(CityRepository $repository,EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    /**
     * @Route("/location/edit/{id<\d+>?0}", name="location_edit")
     */
    public function createLocation($id,Request $request)
    {

        if($id==0) {
            $location = new Location();
        }
        else{
            $location= $this->repository->find($id);
        }
        $locationForm = $this->createForm(InsertLocationType::class,$location);
        $locationForm->handleRequest($request);
        if($locationForm->isSubmitted()){
            $this->em->persist($location);
            $this->em->flush();
            //return $this->redirectToRoute("index");
            return $this->redirectToRoute("home");
        }
        return $this->render('location/edit.html.twig',[
            "locationForm" =>$locationForm->createView()
        ]);
    }

    /**
     * @Route("/location/list", name="location_list")
     */
    public function listCampus( Request $request){

        $locations = $this->repository->findAll();
        return $this->render('location/list.html.twig', [
            'locations' => $locations,
        ]);


    }
}
