<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Entity\EventState;
use App\Form\EventRegisterType;
use App\Form\InsertEventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class EventController extends AbstractController
{
    /**
     * @Route("/user/event/create", name="user_event_create")
     */
    public function createEvent(Request $request,EntityManagerInterface $em)
    {
        if($this->getUser()==null){
            return $this->redirectToRoute("login");
        }
        $dateIsGood=true;
        $event = new Event();
        $eventForm = $this->createForm(InsertEventType::class,$event);
        $eventForm->handleRequest($request);
        if($eventForm->isSubmitted()){
            if($event->getSignInLimit()<=$event->getStart()){
                $organizer=$this->getUser();
                $event->setOrganizer($organizer);
                $stateRepo= $this->getDoctrine()->getRepository(EventState::class);
                $event->setState($stateRepo->findOneBy(['id'=>$event->getState()->getId()]));

                $em->persist($event);
                $em->flush();
                //return $this->redirectToRoute("index");
                return $this->redirectToRoute("UserListEvent");
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
     * @Route("/user/event/list", name="user_event_list")
     */
    public function listEvents(Request $request,EntityManagerInterface $em)
    {
        if($this->getUser()==null){
            return $this->redirectToRoute("event_list");
        }
        $idUser=$this->getUser()->getId();
        $eventRepo= $this->getDoctrine()->getRepository(Event::class);
        $queryOrganized=$eventRepo->findBy(array('organizer'=>$idUser));
        $dql="SELECT e FROM App\Entity\Event e ";
        $dql.="WHERE e.id NOT IN (SELECT e2.id FROM App\Entity\Event e2 LEFT JOIN e2.users u WHERE (e2.organizer=:idUser OR u.id=:idUser)) AND DATE_ADD(e.start,1,'month') > CURRENT_DATE() AND e.state != 1";
        $query = $em -> createQuery($dql);
        $query->setParameter("idUser",$idUser);
        $queryNotJoined = $query->getResult();

        $dql="SELECT e FROM App\Entity\Event e";
        $dql.=" INNER JOIN e.users u WHERE e.organizer != :idUser AND u.id = :idUser AND DATE_ADD(e.start,1,'month') > CURRENT_DATE()";
        $query = $em -> createQuery($dql);
        $query->setParameter("idUser",$idUser);
        $queryJoined = $query->getResult();
        return $this->render("/event/listEvent.html.twig",[
            "organized"=>$queryOrganized,
            "joined"=>$queryJoined,
            "notJoined"=>$queryNotJoined
        ]);
    }

    /**
     * @Route("/event/list", name="event_list")
     */
    public function noUserListEvents(Request $request,EntityManagerInterface $em)
    {
        $dql="SELECT e FROM App\Entity\Event e ";
        $dql.="WHERE DATE_ADD(e.start,1,'month') > CURRENT_DATE() ";
        $query = $em -> createQuery($dql);
        $list = $query->getResult();

        return $this->render("/event/noUserListEvent.html.twig",[
            "List"=>$list
        ]);
    }

    /**
     * @Route("/event/show/{id}", name="event_show")
     */
    public function viewEvent(Request $request,EntityManagerInterface $em,$id)
    {
        if($this->getUser()==null){
            return $this->redirectToRoute("login");
        }
        $user = $this->getUser();
        $idUser=$user->getId();
        $eventRepo= $this->getDoctrine()->getRepository(Event::class);
        $query=$eventRepo->findOneBy(['id'=>$id]);
        $eventForm = $this->createForm(EventRegisterType::class,$user);
        $eventForm->handleRequest($request);

        $isOrganizer=false;
        if($query->getOrganizer()->getId()==$idUser){
            $isOrganizer=true;
        }
        $isJoined=false;
        foreach($query->getUsers() as $eventUser){
            if($eventUser->getId()==$idUser){
                $isJoined=true;
            }
        }
        $isJoinable=true;
        if($query->getSignInLimit()<new \DateTime('now')){
            $isJoinable=false;
        }
        if($eventForm->isSubmitted()){
            if(!$isJoined && !$isOrganizer){
                //$userRepo= $this->getDoctrine()->getRepository(User::class);
                //$user=$userRepo->findOneBy(['id'=>$idUser]);
                $user->addEvent($query);
                $em->persist($user);
                $em->flush();
            }elseif ($isJoined){
                //$userRepo= $this->getDoctrine()->getRepository(User::class);
                //$user=$userRepo->findOneBy(['id'=>$idUser]);
                $user->removeEvent($query);
                $em->persist($user);
                $em->flush();
            }
            return $this->redirectToRoute("event_list");
        }
        return $this->render("/event/viewEvent.html.twig",[
            "isOrganizer"=>$isOrganizer,
            "isJoined"=>$isJoined,
            "isJoinable"=>$isJoinable,
            "eventForm"=>$eventForm->CreateView(),
            "Event"=>$query
        ]);

    }

    /**
     * @Route("/event/edit/{id}", name="event_edit")
     */
    public function editEvent(Request $request,EntityManagerInterface $em,$id)
    {
        if($this->getUser()==null){
            return $this->redirectToRoute("login");
        }
        $dateIsGood=true;
        $eventRepo= $this->getDoctrine()->getRepository(Event::class);
        $event=$eventRepo->findOneBy(['id'=>$id]);
        if($event->getOrganizer()->getId()!=$this->getUser()->getId()){
            return $this->redirectToRoute("user_event_list");
        }
        $eventForm = $this->createForm(InsertEventType::class,$event);
        $eventForm->handleRequest($request);
        if($eventForm->isSubmitted()){
            if($event->getSignInLimit()<=$event->getStart()){
                $stateRepo= $this->getDoctrine()->getRepository(EventState::class);
                $event->setState($stateRepo->findOneBy(['id'=>$event->getState()->getId()]));
                $em->persist($event);
                $em->flush();
                //return $this->redirectToRoute("index");
                return $this->redirectToRoute("user_event_list");
            }else{
                $dateIsGood=false;
            }
        }

        return $this->render('event/createEvent.html.twig',[
            "eventForm" =>$eventForm->createView(),
            "isDateGood" =>$dateIsGood
        ]);
    }

}
