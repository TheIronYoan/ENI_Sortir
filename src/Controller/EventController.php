<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventFilter;
use App\Entity\User;
use App\Entity\EventState;
use App\Form\EventFilterType;
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

    /**
     * @Route("/user/event/list", name="user_event_list")
     */
    public function listEvents(Request $request,EntityManagerInterface $em)
    {
        if($this->getUser()==null){
            return $this->redirectToRoute("event_list");
        }

        $dql="SELECT e as event,COUNT(u) as count FROM App\Entity\Event e ";
        $dql.=" LEFT JOIN e.users u ";

        $showJoined=true;
        $showJoinable=true;
        $eventFilter=new EventFilter();
        $eventForm = $this->createForm(EventFilterType::class,$eventFilter);
        $eventForm->handleRequest($request);
        if($eventForm->isSubmitted()){
            $dql.= $this->commonFilter($eventForm);
            if($eventForm['organizedEvent']->GetData()===false){
                $dql.=" AND e.organizer != '".$this->getUser()->getId()."'";
            }

            if($eventForm['joinedEvent']->GetData()===false){
                $showJoined=false;
            }
            if($eventForm['joinableEvent']->GetData()===false){
                $showJoinable=false;
            }
        }
        $dql.=" GROUP BY e.id";
        $query = $em -> createQuery($dql);
        $events = $query->getResult();



        return $this->render("/event/listEvent.html.twig",[
            "events"=>$events,
            "userId"=>$this->getUser()->getId(),
            "showJoined"=>$showJoined,
            "showJoinable"=>$showJoinable,
            "filterForm"=>$eventForm->createView(),
        ]);
    }


    /**
     * @Route("/user/event/edit/{id}", name="user_event_edit")
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

    /**
     * @Route("/event/list", name="event_list")
     */
    public function noUserListEvents(Request $request,EntityManagerInterface $em)
    {
        if($this->getUser()!=null){
            return $this->redirectToRoute("user_event_list");
        }
        $dql="SELECT e as event,COUNT(u) as count FROM App\Entity\Event e ";
        $dql.=" LEFT JOIN e.users u ";

        $eventFilter=new EventFilter();
        $eventForm = $this->createForm(EventFilterType::class,$eventFilter);
        $eventForm->handleRequest($request);
        if($eventForm->isSubmitted()){
            $dql.=$this->commonFilter($eventForm);
        }
        $dql.=" GROUP BY e.id";
        $query = $em -> createQuery($dql);
        $events = $query->getResult();



        return $this->render("/event/noUserListEvent.html.twig",[
            "events"=>$events,
            "filterForm"=>$eventForm->createView(),
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
        $event=$eventRepo->findOneBy(['id'=>$id]);
        $eventForm = $this->createForm(EventRegisterType::class,$user);
        $eventForm->handleRequest($request);

        $isOrganizer=false;
        if($event->getOrganizer()->getId()==$idUser){
            $isOrganizer=true;
        }
        $isJoined=false;
        foreach($event->getUsers() as $eventUser){
            if($eventUser->getId()==$idUser){
                $isJoined=true;
            }
        }
        $isJoinable=true;
        if($event->getSignInLimit()<new \DateTime('now')){
            $isJoinable=false;
        }
        $dql="SELECT COUNT(u.name) FROM App\Entity\Event e  ";
        $dql.="INNER JOIN e.users u";
        $query = $em -> createQuery($dql);
        $countUser = $query->getSingleScalarResult();
        if($countUser>=$event->getMaxUsers()){
            $isJoinable=false;
        }
        if($eventForm->isSubmitted()){
            if(!$isJoined && !$isOrganizer&& $isJoinable){
                //$userRepo= $this->getDoctrine()->getRepository(User::class);
                //$user=$userRepo->findOneBy(['id'=>$idUser]);
                $user->addEvent($event);
                $em->persist($user);
                $em->flush();
            }elseif ($isJoined){
                //$userRepo= $this->getDoctrine()->getRepository(User::class);
                //$user=$userRepo->findOneBy(['id'=>$idUser]);
                $user->removeEvent($event);
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
            "Event"=>$event
        ]);

    }

    public function commonFilter($eventForm){
        $dql="";
        if($eventForm['city']->GetData()->getId()!=0){
            $dql.=" LEFT JOIN e.location l LEFT JOIN l.city c ";
        }
        $dql.="WHERE DATE_ADD(e.start,1,'month') > CURRENT_DATE() ";
        if(strlen($eventForm['searchZone']->GetData())>0){
            $dql.=" AND e.name LIKE '".$eventForm['searchZone']->GetData()."%'";
        }
        if($eventForm['city']->GetData()->getId()!=0){
            $dql.=" AND c.id = '".$eventForm['city']->GetData()->getId()."'";
        }
        if($eventForm['dateBegin']->GetData()!=null){
            $dql.=" AND e.start > '".$eventForm['dateBegin']->GetData()->format('Y-m-d H:i')."'";
        }
        if($eventForm['dateEnd']->GetData()!=null){
            $dql.=" AND e.start < '".$eventForm['dateEnd']->GetData()->format('Y-m-d H:i')."'";
        }

        if($eventForm['pastEvent']->GetData()===false){
            $dql.=" AND e.start> CURRENT_DATE() ";
        }
        return $dql;
    }
}
