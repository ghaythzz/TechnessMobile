<?php

namespace App\Controller\controllerMobile;

use App\Entity\Ordonnance;
use App\Entity\OrdonnanceMedicament;
use App\Entity\User;
use App\Form\OrdonnanceType;
use App\Repository\ConsultationRepository;
use App\Repository\MedicamentRepository;
use App\Repository\OrdonnanceMedicamentRepository;
use App\Repository\OrdonnanceRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/ordonnanceMobile')]
class OrdonnanceMobileController extends AbstractController
{
    #[Route('/listePatients', name: 'app_ordonnance_index_mobile', methods: ['GET'])]
    public function index(Request $request,OrdonnanceRepository $ordonnanceRepository,SerializerInterface $serializer): Response
    {
        $email = $request->query->get("username");
        $password = $request->query->get("password");

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

        $ord=$ordonnanceRepository->findBy([
            'doctor' => $user]);

        $json=$serializer->serialize($ord,'json', ['groups' => "ordonnances"]);
        return new Response($json);
    }

    #[Route('/user/{id}', name: 'app_user_info', methods: ['GET'])]
    public function getUserInfo(int $id, UserRepository $userRepository, SerializerInterface $serializer): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            return new Response('User not found', Response::HTTP_NOT_FOUND);
        }

        $json = $serializer->serialize($user, 'json', ['groups' => "user"]);

        return new Response($json, Response::HTTP_OK);
    }
    #[Route('/listePatient', name: 'app_ordonnance_index_patient', methods: ['GET'])]
    public function indexPatient(OrdonnanceRepository $ordonnanceRepository,SerializerInterface $serializer): Response
    {
        $ordonnance=$ordonnanceRepository->findAll();
        $json=$serializer->serialize($ordonnance,'json', ['groups' => "ordonnances"]);
        return new Response($json);
    }

    #[Route('/{id}/new', name: 'app_ordonnance_new_mobile', methods: ['POST'])]
    public function new(Request $request, OrdonnanceRepository $ordonnanceRepository, $id, ReservationRepository $reservationRepository,MedicamentRepository $medicamentRepository, OrdonnanceMedicamentRepository $repository, SerializerInterface $serializer ): Response
    {
        $email = $request->query->get("username");
        $commentaire = $request->query->get("commentaire");

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        /*if (empty($data['medicaments'])) {
            $errors['Medicaments'] = 'Medicaments doit etre remplits';
        }
        if (empty($data['commentaire'])) {
            $errors['commentaire'] = 'Commentaire doit etre remplits';
        }
        if (!empty($errors)) {
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
        }*/

        $ordonnance = new Ordonnance();
        $consultation = $reservationRepository->find((int)$id);
        /*foreach ($data['medicaments'] as $medicament) {
            $med = $medicamentRepository->find((int)$medicament['medicament_id']);
            if (!$med) {
                return new JsonResponse('Medicament with id: ' . $medicament['medicament_id'] . ' is not found');
            } else {
                $ordonnanceMedicament = new OrdonnanceMedicament();
                $ordonnanceMedicament->setOrdonnance($ordonnance);
                $ordonnanceMedicament->setMedicament($med);
                $ordonnanceMedicament->setDosage($medicament['dosage']);
                $ordonnanceMedicament->setDuration($medicament['duration']);
                $ordonnance->addOrdonnanceMedicament($ordonnanceMedicament);
            }
        }*/
        $ordonnance->setDoctor($user);
        $ordonnance->setPatient($consultation->getPatient());
        $ordonnance->setNomPatient($consultation->getPatient()->getNom());
        $ordonnance->setReservations($consultation);
        $ordonnance->setNomMedecin($user->getNom());
        $ordonnance->setDate(new DateTime());
        $ordonnance->setCommentaire($commentaire);

        $ordonnanceRepository->save($ordonnance, true);
        $json=$serializer->serialize($ordonnance,'json', ['groups' => "ordonnances"]);
        return new Response($json);

    }

    #[Route('/{id}', name: 'app_ordonnance_show_mobile', methods: ['GET'])]
    public function show(Ordonnance $ordonnance): Response
    {
        return $this->render('ordonnance/Doctor/show.html.twig', [
            'ordonnance' => $ordonnance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ordonnance_edit_mobile', methods: ['PUT'])]
    public function edit(Request $req, Ordonnance $ordonnance,MedicamentRepository $medicamentRepository, OrdonnanceRepository $ordonnanceRepository, OrdonnanceMedicamentRepository $repository, SerializerInterface $serializer): Response
    {
        $commentaire = $req->query->get("commentaire");
        //$data = json_decode($req->getContent(), true);
        /*var_dump($data);
        foreach ($ordonnance->getOrdonnanceMedicaments() as $medicament) {
            $ordonnance->removeOrdonnanceMedicament($medicament);
            $repository->remove($medicament);
        }*/
        /*foreach ($data['medicaments'] as $medicament) {
            $med = $medicamentRepository->find((int)$medicament['medicament_id']);
            if (!$med) {
                return new JsonResponse('Medicament with id: ' . $medicament['medicament_id'] . ' is not found');
            } else {
                $ordonnanceMedicament = new OrdonnanceMedicament();
                $ordonnanceMedicament->setOrdonnance($ordonnance);
                $ordonnanceMedicament->setMedicament($med);
                $ordonnanceMedicament->setDosage($medicament['dosage']);
                $ordonnanceMedicament->setDuration($medicament['duration']);
                $ordonnance->addOrdonnanceMedicament($ordonnanceMedicament);
            }
        }*/
        $ordonnance->setDate(new DateTime());
        $ordonnance->setCommentaire($commentaire);
        $ordonnanceRepository->save($ordonnance, true);
        $json=$serializer->serialize($ordonnance,'json', ['groups' => "ordonnances"]);
        return new Response($json);
    }

    #[Route('/delete/{id}', name: 'app_ordonnance_delete_mobile', methods: ['DELETE'])]
    public function delete(Ordonnance $ordonnance, OrdonnanceRepository $ordonnanceRepository, OrdonnanceMedicamentRepository $repository,SerializerInterface $serializer): Response
    {
        $ordonnanceRepository->remove($ordonnance, true);
        $json=$serializer->serialize($ordonnance,'json', ['groups' => "ordonnances"]);
        return new Response($json);
        //return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
    }
}
