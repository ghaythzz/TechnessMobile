<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Speciality;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use App\Repository\SpecialityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation_med')]

class ReservationMedController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index_med', methods: ['GET'])]
    public function index_med(UserRepository $userRepository,ReservationRepository $reservationRepository): Response
    {
        $userp = $this->getUser()->getId();
        return $this->render('reservation_med/display_med.html.twig', [

            'reservations' => $reservationRepository->ghayth_med($userp),
           
        ]);
    }



    #[Route('/{id}', name: 'app_reservation_delete_bymed', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $reservationRepository->remove($reservation, true);
        }

        return $this->redirectToRoute('app_reservation_index_med', [], Response::HTTP_SEE_OTHER);
    }


}
