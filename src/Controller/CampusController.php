<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use App\Repository\CampusRepository;
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
     * @var CampusRepositoryRepository
     */

    private $repository;

    /**
     * @var ObjectManager
     */

    private $em;


    public function __construct(CampusRepository $repository,EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    /**
     * @Route("/campus/create", name="campus_create")
     */
    public function create( Request $request
                        )
                {
        $campus = new Campus();
        $campusForm = $this->createForm(CampusType::class,$campus);
        $campusForm->handleRequest($request);
        if($campusForm->isSubmitted()){
            $this->em->persist($campus);
            $this->em->flush();
            //return $this->redirectToRoute("index");
            return $this->redirectToRoute("home");
        }

        return $this->render('campus/create.html.twig',[
            "campusForm" =>$campusForm->createView()
        ]);
    }
/**
 * @Route("/campus/edit", name="campus_edit")
 */
    public function edit( $id,Request $request
    )
    {
        $campus = $this->em->find($id);

        $campusForm = $this->createForm(CampusType::class,$campus);
        $campusForm->handleRequest($request);

        if($campusForm->isSubmitted()){
            $this->em->persist($campus);
            $this->em->flush();
            return $this->redirectToRoute("home");
        }

        return $this->render('campus/index.html.twig',[

            'campus' => $campus,
            "campusForm" =>$campusForm->createView()
        ]);
    }
    /**
     * @Route("/campus/list", name="campus_list")
     */
    public function listCampus( ){

        $campus = $this->repository->findAll();
        return $this->render('campus/list.html.twig', [
            'campus' => $campus,
        ]);


    }

}
