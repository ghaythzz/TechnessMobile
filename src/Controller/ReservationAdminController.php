<?php

namespace App\Controller;

use App\Entity\Rate;
use App\Form\RateType;
use App\Repository\RateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Speciality;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use App\Repository\SpecialityRepository;

class ReservationAdminController extends AbstractController
{
    #[Route('/resback', name: 'app_reservation_admin')]
    public function displayUsersForAdmin(ReservationRepository $reservationRepository): Response
    {       $res=$reservationRepository->findAll();
        
              //$khouna= $res->getUsers();

        return $this->render('/back_office/reservation_admin_back/basic.html.twig', [
            'reservations' => $res
            ,
            //'users' => $userRepository->find($khouna),
        ]);
    }


    
    #[Route('/dispRates', name: 'app_adminres_show', methods: ['GET'])]
    public function displayRatesForAdmin(RateRepository $rateRepository ): Response
    {
       
        return $this->render('/back_office/reservation_admin_back/show.html.twig', [
            
             'rates' => $rateRepository->findAll(),
        ]);
    }

    

}
