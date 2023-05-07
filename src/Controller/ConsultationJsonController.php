<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Consultation;
use App\Repository\ConsultationRepository;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Entity\Rate;
use App\Repository\RateRepository;
use App\Entity\User;


class ConsultationJsonController extends AbstractController
{
   
    #[Route('/get', name: 'consultations')]
    public function getConsultations(ConsultationRepository $repo, SerializerInterface $serializer)
    {

    $Cons = $repo->findAll();
    $json = $serializer->serialize($Cons, 'json', ['groups' => "consultations"]);  

        return new Response($json);
        
    }
  


    #[Route('/getres', name: 'reserv')]
    public function getReservations(ReservationRepository $repo, SerializerInterface $serializer)
    {

    $Cons = $repo->findAll();
    $json = $serializer->serialize($Cons, 'json', ['groups' => "reservations"]);  

        return new Response($json);
        
    }


        #[Route('/create', name: 'addCons')]
        public function addConsultation(Request $req , SerializerInterface $serializer)
        {

        $em = $this->getDoctrine()->getManager();
        $Consultation = new Consultation();
        
        $Consultation ->setStart($req->get('start'));
        $Consultation ->setEnd($req->get('end'));
        $Consultation ->setComment($req->get('comment'));
       
        $em->persist($Consultation);
        $em->flush();


        $json = $serializer->serialize($Consultation, 'json', ['groups' => "consultations"]);
    
        return new Response($json);
            
        }


        #[Route('/createres', name: 'addres')]
        public function addReservation(Request $req , SerializerInterface $serializer)
        {

        $em = $this->getDoctrine()->getManager();
        $Consultation = new Reservation();
        $start = new \DateTime($req->query->get('start'));
        $end = new \DateTime($req->query->get('end'));
        
        $Consultation ->setStart($start);
        $Consultation ->setEnd($end);
        $Consultation ->setComment($req->get('comment'));
       
        $em->persist($Consultation);
        $em->flush();


        $json = $serializer->serialize($Consultation, 'json', ['groups' => "reservations"]);
    
        return new Response($json);
            
        }



    #[Route('/u/{id}', name: 'yyyy')]
    public function updateCons($id,Request $req , SerializerInterface $serializer,ConsultationRepository $repo)
    {

    $em = $this->getDoctrine()->getManager();
    $Consultation = $repo->find($id);
    $Consultation ->setStatus($req->get('date'));
    $Consultation ->setName($req->get('comment'));
    $Consultation ->setMedecin($req->get('medecin'));
   
    $em->persist($Consultation);
    $em->flush();


    $json = $serializer->serialize($Consultation, 'json', ['groups' => "consultations"]);
    
       
    return new Response($json);
        
    }



    #[Route('/delete/{id}', name: 'delcons')]
    public function deleteCons($id,SerializerInterface $serializer,Consultation $consultation ,ConsultationRepository $repo)
    {

   // $em = $this->getDoctrine()->getManager();
    $consultation = $repo->find($id);
    $repo->remove($consultation, true);
   // $em->remove($reservation);
    //$em->flush();
    $json = $serializer->serialize($consultation, 'json', ['groups' => "consultations"]);
    
    return new Response($json);
        
    }



    #[Route('/deleteres/{id}', name: 'delres')]
    public function deleteRes($id,SerializerInterface $serializer,Reservation $res ,ReservationRepository $repo)
    {

   // $em = $this->getDoctrine()->getManager();
    $res = $repo->find($id);
    $repo->remove($res, true);
   // $em->remove($reservation);
    //$em->flush();
    $json = $serializer->serialize($res, 'json', ['groups' => "reservations"]);
    
    return new Response($json);
        
    }





}
