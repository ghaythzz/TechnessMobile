<?php

namespace App\Controller\controllerMobile;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/patientsMobile')]
class PatientMobileController extends AbstractController
{
    #[Route('/', name: 'app_doctor_patient_index_mobile', methods: ['GET'])]
    public function index(SerializerInterface $serializer,Request $request): Response
    {
        $email = $request->query->get("username");
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        $pat=$user->getPatients();
        $json=$serializer->serialize($pat,'json', ['groups' => "users"]);
        return new Response($json);
    }
}
