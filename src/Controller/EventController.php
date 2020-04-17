<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\InsertEventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/user/CreateEvent", name="CreateEvent")
     */
    public function createEvent(Request $request,EntityManagerInterface $em)
    {
        $event = new Event();
        $eventForm = $this->createForm(InsertEventType::class,$event);
        $eventForm->handleRequest($request);
        if($eventForm->isSubmitted()){
            $em->persist($event);
            $em->flush();
            //return $this->redirectToRoute("index");
            return $this->redirectToRoute("CreateEvent");
        }

        return $this->render('event/createEvent.html.twig',[
            "eventForm" =>$eventForm->createView()
        ]);
    }
}
