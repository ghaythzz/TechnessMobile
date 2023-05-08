<?php

namespace App\Controller\controllerMobile;

use App\Entity\Fiche;
use App\Entity\Ordonnance;
use App\Entity\OrdonnanceMedicament;
use App\Entity\User;
use App\Form\FicheType;
use App\Repository\FicheRepository;
use App\Repository\OrdonnanceRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/ficheMobile')]
class FicheMobileController extends AbstractController
{
    #[Route('/{id}', name: 'app_fiche_index_mobile', methods: ['GET'])]
    public function index(Request $request,SerializerInterface $serializer, UserRepository $userRepository, FicheRepository $ficheRepository, ReservationRepository $reservationRepository, OrdonnanceRepository $ordonnanceRepository,$id): Response
    {
        $patient = $userRepository->find($id);
        $email = $request->query->get("username");


        $em = $this->getDoctrine()->getManager();
        $doctor = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        $fiche = $ficheRepository->findOneBy([
            'patient' => $patient,
            'doctor' => $doctor
        ]);
        $reservations = $reservationRepository->getReservationByFiche($fiche->getId());
        $ordonnances = $ordonnanceRepository->getOrdonnaceByFiche($fiche->getId());

        $json=$serializer->serialize($fiche,'json', ['groups' => "fiches"]);
        return new Response($json);
    }

    #[Route('/{id}/new', name: 'app_fiche_new_mobile', methods: ['POST'])]
    public function new(Request $req, FicheRepository $ficheRepository,$id, ReservationRepository $reservationRepository,SerializerInterface $serializer): Response
    {
        $errors = [];
        $data = json_decode($req->getContent(), true);
        if (empty($data['tel'])) {
            $errors['tel'] = 'tel doit etre remplits';
        }
        if (empty($data['etat_clinique'])) {
            $errors['etat_clinique'] = 'etat_clinique doit etre remplits';
        }
        if (empty($data['genre'])) {
            $errors['genre'] = 'genre doit etre remplits';
        }
        if (empty($data['type_assurance'])) {
            $errors['type_assurance'] = 'type_assurance doit etre remplits';
        }
        if (!empty($errors)) {
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
        }
        /** @var User $user */
        $user = $this->getUser();
        $fiche = new Fiche();
        $consultation = $reservationRepository->find((int)$id);

        $fiche->setDoctor($user);
        $fiche->setPatient($consultation->getPatient());
        $fiche->setTel($data['tel']);
        $fiche->setEtatClinique($data['etat_clinique']);
        $fiche->setGenre($data['genre']);
        $fiche->setDateNaissance($data['date_naissance']);
        $fiche->setTypeAssurance($data['type_assurance']);

        $ficheRepository->save($fiche, true);
        $json=$serializer->serialize($fiche,'json', ['groups' => "fiches"]);
        return new Response($json);
    }

    #[Route('/{id}', name: 'app_fiche_show_mobile', methods: ['GET'])]
    public function show(Fiche $fiche): Response
    {
        return $this->render('fiche/Doctor/show.html.twig', [
            'fiche' => $fiche,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fiche_edit_mobile', methods: ['PUT'])]
    public function edit(Request $request, Fiche $fiche, FicheRepository $ficheRepository,SerializerInterface $serializer): Response
    {
        $tel = $request->query->get("tel");
        $etat_clinique = $request->query->get("etat_clinique");
        $genre = $request->query->get("genre");
        $type_assurance = $request->query->get("type_assurance");
        $fiche->setTel($tel);
        $fiche->setEtatClinique($etat_clinique);
        $fiche->setGenre($genre);
        //$fiche->setDateNaissance($data['date_naissance']);
        $fiche->setTypeAssurance($type_assurance);
        $ficheRepository->save($fiche, true);
        $json=$serializer->serialize($fiche,'json', ['groups' => "fiches"]);
        return new Response($json);
    }

    #[Route('/{id}/delete', name: 'app_fiche_delete_mobile', methods: ['DELETE'])]
    public function delete(Request $request, Fiche $fiche, FicheRepository $ficheRepository,SerializerInterface $serializer): Response
    {
        $ficheRepository->remove($fiche, true);
        $json=$serializer->serialize($fiche,'json', ['groups' => "fiches"]);
        return new Response($json);

    }
}
