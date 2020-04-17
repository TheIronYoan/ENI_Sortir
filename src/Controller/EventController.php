<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Form\InsertEventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class EventController extends AbstractController
{
    /**
     * @Route("/event/CreateEvent", name="CreateEvent")
     */
    public function createEvent(Request $request,EntityManagerInterface $em)
    {
        $dateIsGood=true;
        $event = new Event();
        $eventForm = $this->createForm(InsertEventType::class,$event);
        $eventForm->handleRequest($request);
        if($eventForm->isSubmitted()){
            if($event->getSignInLimit()<=$event->getStart()){
                $organizer=$em->getRepository(User::class)->find(3);
                $event->setOrganizer($organizer);
                $em->persist($event);
                $em->flush();
                //return $this->redirectToRoute("index");
                return $this->redirectToRoute("CreateEvent");
            }else{
                $dateIsGood=false;
            }
        }

        return $this->render('event/createEvent.html.twig',[
            "eventForm" =>$eventForm->createView(),
            "isDateGood" =>$dateIsGood
        ]);
    }

    /**
     * @Route("/event/ListEvent", name="ListEvent")
     */
    public function listEvents(Request $request,EntityManagerInterface $em)
    {
        $idUser=3;
        $eventRepo= $this->getDoctrine()->getRepository(Event::class);
        $queryOrganized=$eventRepo->findBy(array('organizer'=>$idUser));
        $dql="SELECT e FROM App\Entity\Event e";
        $dql.=" WHERE e.organizer != :idUser";
        $query = $em -> createQuery($dql);
        $query->setParameter("idUser",$idUser);
        $queryNotJoined = $query->getResult();

        return $this->render("/event/listEvent.html.twig",[
            "organized"=>$queryOrganized,
            "notJoined"=>$queryNotJoined
        ]);

    }
}
