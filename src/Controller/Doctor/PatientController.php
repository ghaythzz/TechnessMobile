<?php

namespace App\Controller\Doctor;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/patients')]
class PatientController extends AbstractController
{
    #[Route('/', name: 'app_doctor_patient_index')]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $pat=$user->getPatients();
        return $this->render('doctor/patient/index.html.twig', [
            'patients' => $pat
        ]);
    }

}
