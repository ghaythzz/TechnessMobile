<?php

namespace App\Controller\Doctor;

use App\Entity\Fiche;
use App\Entity\User;
use App\Form\FicheType;
use App\Repository\FicheRepository;
use App\Repository\OrdonnanceRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use App\Service\PdfGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/fiche')]
class FicheController extends AbstractController
{
    #[Route('/{id}', name: 'app_fiche_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, FicheRepository $ficheRepository, ReservationRepository $reservationRepository, OrdonnanceRepository $ordonnanceRepository,$id): Response
    {
        $patient = $userRepository->find($id);
        /** @var User $doctor */
        $doctor = $this->getUser();
        $fiche = $ficheRepository->findOneBy([
            'patient' => $patient,
            'doctor' => $doctor
        ]);
        $reservations = $reservationRepository->getReservationByFiche($fiche->getId());
        $ordonnances = $ordonnanceRepository->getOrdonnaceByFiche($fiche->getId());

        return $this->render('fiche/Doctor/index.html.twig', [
            'fiche' => $fiche,
            'reservations' => $reservations,
            'ordonnances' => $ordonnances
        ]);
    }
    #[Route('/{id}/pdf', name: 'app_fiche_pdf', methods: ['GET'])]
    public function indexPdf(UserRepository $userRepository,PdfGenerator $pdfGenerator, FicheRepository $ficheRepository, ReservationRepository $reservationRepository, OrdonnanceRepository $ordonnanceRepository,$id): Response
    {

        $patient = $userRepository->find($id);
        /** @var User $doctor */
        $doctor = $this->getUser();
        $fiche = $ficheRepository->findOneBy([
            'patient' => $patient,
            'doctor' => $doctor
        ]);
        $reservations = $reservationRepository->getReservationByFiche($fiche->getId());
        $ordonnances = $ordonnanceRepository->getOrdonnaceByFiche($fiche->getId());


        // Instantiate Dompdf with our options

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('fiche/Doctor/pdf.html.twig', [
            'fiche' => $fiche,
            'reservations' => $reservations,
            'ordonnances' => $ordonnances
        ]);
        $pdfContent = $pdfGenerator->generatePdf($html);
        // Load HTML to Dompdf




        // Render the HTML as PDF
        return new Response(
            $pdfContent,
            Response::HTTP_OK,
            array(
                'Content-Type' => 'application/pdf',

                "Attachment" => false
            )
        );

    }


    #[Route('/{id}/new', name: 'app_fiche_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FicheRepository $ficheRepository,$id, ReservationRepository $reservationRepository): Response
    {
        $consultation = $reservationRepository->find((int)$id);
        $fiche = new Fiche();
        $fiche->setNomPatient($consultation->getPatient()->getNom().' '.$consultation->getPatient()->getPrenom());
        $fiche->setEmail($consultation->getPatient()->getEmail());
        $fiche->setTel($consultation->getPatient()->getNumero());
        $form = $this->createForm(FicheType::class, $fiche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ficheRepository->save($fiche, true);

            return $this->redirectToRoute('app_fiche_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fiche/Doctor/new.html.twig', [
            'fiche' => $fiche,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fiche_show', methods: ['GET'])]
    public function show(Fiche $fiche): Response
    {
        return $this->render('fiche/Doctor/show.html.twig', [
            'fiche' => $fiche,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fiche_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fiche $fiche, FicheRepository $ficheRepository): Response
    {
        $form = $this->createForm(FicheType::class, $fiche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ficheRepository->save($fiche, true);

            return $this->redirectToRoute('app_fiche_index', [
                'id' => $fiche->getPatient()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fiche/Doctor/edit.html.twig', [
            'fiche' => $fiche,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_fiche_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Fiche $fiche, FicheRepository $ficheRepository): Response
    {
        $ficheRepository->remove($fiche, true);

        return $this->redirectToRoute('app_fiche_index', [], Response::HTTP_SEE_OTHER);
    }
}
