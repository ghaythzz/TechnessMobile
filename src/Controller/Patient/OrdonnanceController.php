<?php

namespace App\Controller\Patient;

use App\Entity\User;
use App\Repository\OrdonnanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ordonnance')]
class OrdonnanceController extends AbstractController
{
    #[Route('/', name: 'app_ordonnance_patient_index', methods: ['GET', 'POST'])]
    public function show(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        return $this->render('ordonnance/Patient/showOrdonnance.html.twig', [
            'ordonnances' => $user->getOrdPatients()
        ]);
    }

}