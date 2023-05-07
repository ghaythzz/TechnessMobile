<?php

namespace App\Controller;

use App\Entity\Pharmacie;
use App\Form\PharmacieType;
use App\Repository\PharmacieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator;

#[Route('/pharmacie')]
class PharmacieController extends AbstractController
{
    #[Route('/', name: 'app_pharmacie_index', methods: ['GET'])]
    public function index(PharmacieRepository $pharmacieRepository): Response
    {
        return $this->render('/back_office/pharmacie/index.html.twig', [
            'pharmacies' => $pharmacieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pharmacie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PharmacieRepository $pharmacieRepository): Response
    {
        $pharmacie = new Pharmacie();
        $form = $this->createForm(PharmacieType::class, $pharmacie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pharmacieRepository->save($pharmacie, true);

            return $this->redirectToRoute('app_pharmacie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back_office/pharmacie/new.html.twig', [
            'pharmacie' => $pharmacie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pharmacie_show', methods: ['GET'])]
    public function show(Pharmacie $pharmacie): Response
    {
        return $this->render('back_office/pharmacie/show.html.twig', [
            'pharmacie' => $pharmacie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pharmacie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pharmacie $pharmacie, PharmacieRepository $pharmacieRepository): Response
    {
        $form = $this->createForm(PharmacieType::class, $pharmacie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pharmacieRepository->save($pharmacie, true);

            return $this->redirectToRoute('app_pharmacie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back_office/pharmacie/edit.html.twig', [
            'pharmacie' => $pharmacie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_pharmacie_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Pharmacie $pharmacie, PharmacieRepository $pharmacieRepository): Response
    {
            $pharmacieRepository->remove($pharmacie, true);

        return $this->redirectToRoute('app_pharmacie_index', [], Response::HTTP_SEE_OTHER);
    }
}
