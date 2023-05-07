<?php

namespace App\Controller\Doctor;

use App\Entity\Ordonnance;
use App\Entity\OrdonnanceMedicament;
use App\Entity\User;
use App\Form\OrdonnanceFilterType;
use App\Form\OrdonnanceType;
use App\Repository\OrdonnanceMedicamentRepository;
use App\Repository\OrdonnanceRepository;
use App\Repository\ReservationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\MailerService;

#[Route('/ordonnance')]
class OrdonnanceController extends AbstractController
{
    #[Route('/', name: 'app_ordonnance_index', methods: ['GET'])]
    public function index(Request $request, OrdonnanceRepository $ordonnanceRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(OrdonnanceFilterType::class);
        $queries = $request->query->all();
        $nom = $queries['name'] ?? null;
        $date = $queries['date'] ?? null;
        $commentaire = $queries['commentaire'] ?? '';
        $ordonnances = $ordonnanceRepository->search($nom,$date,$commentaire,$user->getId());
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'data' => $this->renderView('ordonnance/Doctor/table_content.html.twig', [
                    'ordonnances' => $ordonnances
                ])
            ]);
        }
        return $this->render('ordonnance/Doctor/index.html.twig', [
            'ordonnances' => $ordonnances,
            'form' => $form->createView()
        ]);
    }


    #[Route('/{id}/new', name: 'app_ordonnance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrdonnanceRepository $ordonnanceRepository, $id, ReservationRepository $reservationRepository, OrdonnanceMedicamentRepository $repository,MailerService $mailerService ): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $consultation = $reservationRepository->find((int)$id);
        $ordonnance = new Ordonnance();
        $ordonnance->setNomMedecin($user->getNom().' '.$user->getPrenom());
        $ordonnance->setNomPatient($consultation->getPatient());
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->get('ordonnanceMedicaments')->setData([[
            'dosage' => null,
            'duration' => null,
            'medicament' => null
        ]]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $ordonnance->setNomMedecin($user->getNom().' '.$user->getPrenom());
            $ordonnance->setDate(new DateTime());
            $ordonnance->setDoctor($user);
            $ordonnance->setPatient($consultation->getPatient());
            $ordonnance->setReservations($consultation);
            $meds = $form->get('ordonnanceMedicaments')->getData();
            foreach ($meds as $med) {
                if ($med['duration'] && $med['dosage'] && $med['medicament']) {
                    $ordMed = new OrdonnanceMedicament();
                    $ordMed->setDuration($med['duration'])
                        ->setDosage($med['dosage'])
                        ->setMedicament($med['medicament']);
                    $ordMed->setOrdonnance($ordonnance);
                    $ordonnance->addOrdonnanceMedicament($ordMed);
                    $repository->save($ordMed);
                }
            }
            $ordonnanceRepository->save($ordonnance, true);

            return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ordonnance/Doctor/new.html.twig', [
            'ordonnance' => $ordonnance,
            'patient' => $consultation->getPatient(),
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ordonnance_show', methods: ['GET'])]
    public function show(Ordonnance $ordonnance): Response
    {
        return $this->render('ordonnance/Doctor/show.html.twig', [
            'ordonnance' => $ordonnance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ordonnance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ordonnance $ordonnance, OrdonnanceRepository $ordonnanceRepository, OrdonnanceMedicamentRepository $repository,MailerService $mailerService): Response
    {
        $oldMeds = $ordonnance->getOrdonnanceMedicaments();
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        if(count($oldMeds) === 0) {
            $form->get('ordonnanceMedicaments')->setData([[
                'dosage' => null,
                'duration' => null,
                'medicament' => null
            ]]);
        } else {
            $data = [];
            foreach ($oldMeds as $oldMed) {
                $data[] = [
                    'dosage' => $oldMed->getDosage(),
                    'duration' => $oldMed->getDuration(),
                    'medicament' => $oldMed->getMedicament()
                ];
            }
            $form->get('ordonnanceMedicaments')->setData($data);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ordonnance->setDoctor($user);
            foreach ($oldMeds as $oldMed) {
                $ordonnance->removeOrdonnanceMedicament($oldMed);
                $medicament = $oldMed->getMedicament();
                $medicament->removeOrdonnanceMedicament($oldMed);
                $repository->remove($oldMed);
            }

            $meds = $form->get('ordonnanceMedicaments')->getData();
            foreach ($meds as $med) {
                if ($med['duration'] && $med['dosage'] && $med['medicament']) {
                    $ordMed = new OrdonnanceMedicament();
                    $ordMed->setDuration($med['duration'])
                        ->setDosage($med['dosage'])
                        ->setMedicament($med['medicament']);
                    $ordMed->setOrdonnance($ordonnance);
                    $ordonnance->addOrdonnanceMedicament($ordMed);
                    $repository->save($ordMed);
                }
            }
            $mailerService->send("Ordonnance a été changé",$user->getEmail(),$ordonnance->getPatient()->getEmail(),"ordonnance/Doctor/email.html.twig",[
                "name" => $ordonnance->getPatient()->getNom(),
                "description" => $ordonnance->getCommentaire()
            ]);
            $ordonnanceRepository->save($ordonnance, true);

            return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ordonnance/Doctor/edit.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_ordonnance_delete', methods: ['GET','POST'])]
    public function delete(Ordonnance $ordonnance, OrdonnanceRepository $ordonnanceRepository, OrdonnanceMedicamentRepository $repository): Response
    {
        $oldMeds = $ordonnance->getOrdonnanceMedicaments();
        foreach ($oldMeds as $oldMed) {
            $ordonnance->removeOrdonnanceMedicament($oldMed);
            $medicament = $oldMed->getMedicament();
            $medicament->removeOrdonnanceMedicament($oldMed);
            $repository->remove($oldMed);
        }
        $ordonnanceRepository->remove($ordonnance, true);

        return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
    }
    public function searchOrdonnance(Request $request, OrdonnanceRepository $ordonnanceRepository)
    {
        $query = $request->query->get('query');

        $ordonnances = $ordonnanceRepository->search($query);
        $jsonData = array();
        $idx = 0;
        foreach($ordonnances as $ordonnances) {
            $temp = array(
                'id' => $ordonnances->getId(),

            );
            $jsonData[$idx++] = $temp;
            dump($jsonData);die;
        }
        return new JsonResponse($jsonData);


    }
}
