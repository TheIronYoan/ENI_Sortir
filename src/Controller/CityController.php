<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/user/city", name="user_city_")
 */

class CityController extends AbstractController
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
     * @Route("/list", name="list")
     */
    public function list( Request $request
    )
    {
        $cities = $this->repository->findAll();
        return $this->render('city/list.html.twig', [
            '$cities' => $cities,
        ]);
    }


    /**
     *
     * @Route("/edit/{id<\d+>?0}", name="edit")
     */
    public function edit( $id,Request $request
    )
    {

        if($id==0){
            $city =new City();
        }
        else{
            $city = $this->repository->find($id);
        }

        $cityForm = $this->createForm(CityType::class,$city);
        $cityForm->handleRequest($request);

        if($cityForm->isSubmitted() && $cityForm->isValid()){


            $this->em->persist($city);
            $this->em->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render('city/edit.html.twig',[

            'city' => $city,
            "cityForm" =>$cityForm->createView()
        ]);
    }
}
