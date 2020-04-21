<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Location;
use App\Form\InsertCityType;
use App\Form\InsertLocationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/site/CreateCity", name="CreateCity")
     */
    public function createCity(Request $request,EntityManagerInterface $em)
    {
        $city = new City();
        $cityForm = $this->createForm(InsertCityType::class,$city);
        $cityForm->handleRequest($request);
        if($cityForm->isSubmitted()){
            $em->persist($city);
            $em->flush();
               //return $this->redirectToRoute("index");
            return $this->redirectToRoute("home");
        }

        return $this->render('site/CreateCity.html.twig',[
            "cityForm" =>$cityForm->createView()
        ]);
    }

    /**
     * @Route("/site/CreateLocation", name="CreateLocation")
     */
    public function createLocation(Request $request,EntityManagerInterface $em)
    {
        $cityRepo= $this->getDoctrine()->getRepository(City::class);
        $query=$cityRepo->findAll();
        $cities=['EGGZEMPLE'=>new City()];
        foreach ($query as $thisCity){
            array_push($cities,$thisCity->getName(),$thisCity);
        }

        $location = new Location();
        $locationForm = $this->createForm(InsertLocationType::class,$location,['cities'=>$cities,]);
        $locationForm->handleRequest($request);
        if($locationForm->isSubmitted()){
            $em->persist($location);
            $em->flush();
            //return $this->redirectToRoute("index");
            return $this->redirectToRoute("home");
        }
        return $this->render('site/CreateLocation.html.twig',[
            "locationForm" =>$locationForm->createView()
        ]);
    }
}
