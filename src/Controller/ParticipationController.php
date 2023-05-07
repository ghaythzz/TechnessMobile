<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Evenement;
use App\Entity\Participation;
use App\Form\ParticipationType;
use App\Repository\ParticipationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\EvenementRepository;

use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

#[Route('/participation')]
class ParticipationController extends AbstractController
{
    #[Route('/part', name: 'app_participation_index', methods: ['GET'])]
    public function index(ParticipationRepository $participationRepository, EvenementRepository $evenementRepository,UserRepository $userRepository): Response
    {
        return $this->render('participation/index.html.twig', [
            'participations' => $participationRepository->findAll(),
        ]);
    }
   

    #[Route('/new/{event}', name: 'app_participation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ParticipationRepository $participationRepository ,UserRepository $userRepository,EvenementRepository $evenementRepository): Response
    {
        $Eid = $request->get("event");
        
        $participation = new Participation();
        $userp = $this->getUser();
        $participation ->setUserId($userRepository->find($userp));
        $participation ->setEvent($evenementRepository->find($Eid));
      

        
        $participationRepository->save($participation,true);

        
        return $this->redirectToRoute('app_evenement_index_front', [], Response::HTTP_SEE_OTHER);
        ;
    }


    #[Route('/{id}', name: 'app_participation_show', methods: ['GET'])]
    public function show(Participation $participation): Response
    {
        return $this->render('participation/show.html.twig', [
            'participation' => $participation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_participation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Participation $participation, ParticipationRepository $participationRepository): Response
    {
        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participationRepository->save($participation, true);

            return $this->redirectToRoute('app_participation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('participation/edit.html.twig', [
            'participation' => $participation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_participation_delete', methods: ['POST'])]
    public function delete(Request $request, Participation $participation, ParticipationRepository $participationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participation->getId(), $request->request->get('_token'))) {
            $participationRepository->remove($participation, true);
        }

        return $this->redirectToRoute('app_participation_index', [], Response::HTTP_SEE_OTHER);
    }
}
