<?php

namespace App\Controller\controllerMobile;

use App\Entity\Reservation;
use App\Entity\User;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/reservationMobile')]
class ReservationMobileController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index_med_mobile', methods: ['GET'])]
    public function index_med(Request $request,UserRepository $userRepository, ReservationRepository $reservationRepository, SerializerInterface $serializer): Response
    {
        $email = $request->query->get("username");


        $em = $this->getDoctrine()->getManager();
        $doctor = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        $doctorId = $doctor->getId();
        $ord = $reservationRepository->ghayth_med($doctorId);
        $json = $serializer->serialize($ord, 'json', ['groups' => "resers"]);
        return new Response($json);

    }
}
