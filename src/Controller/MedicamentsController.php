<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Med;
use App\Repository\MedRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;




//#[Route('/Firas')]
class MedicamentsController extends AbstractController
{

    #[Route('/ghayth', name: 'app_meds')]
    public function meds(MedRepository $medRepository ,SerializerInterface $serializer )
    {
        $med = $medRepository->findAll();
        //dump($medicaments);
        //die;
       // $medicamentsNormalises = $normalizer->normalize($medicaments,'json' ,['groups' =>"medicaments"]);
       //  $json = json_encode($medicamentsNormalises);
        $json = $serializer-> serialize($med, 'json' , ['groups' => "meds"]);
       
        return new Response($json);

          }
    
          /*#[Route('/medicaments/{id}', name: 'app_medicaments')]
      public function medicamentsid($id, NormalizerInterface $normalizer , MedicamentRepository $repo)
      {
        $medicaments=$repo->find($id);
        $medicamentsNormalises = $normalizer->normalize($medicaments,'json' ,['groups' =>"medicaments"]);
        return new Response(json_encode($medicamentsNormalises));

    }
    #[Route('addmedicamentsJson/new', name: 'app_medicaments_new',methods: ['POST'])]
    public function addmedicamentsJson(Request $req, NormalizerInterface $Normalizer ,PharmacieRepository $pharmacieRepositry)
    {
      
      $em = $this->getDoctrine()->getManager();
      $ph = $pharmacieRepositry->find($req->get('Pharmacie'));
      $medicaments = new Medicament();
      $medicaments->addIdPharmacie($ph);
      $medicaments->setNom($req->get('Nom'));
      $medicaments->setType($req->get('Type'));
      $medicaments->setNbdose($req->get('Nb_dose'));
      $medicaments->setPrix($req->get('Prix'));
      $medicaments->setStock($req->get('Stock'));    
      $em->persist($medicaments);
      $em->flush();
      $jsonContent = $Normalizer->normalize($medicaments, 'json',['groups'=>'medicaments']);
      return new Response(json_encode($jsonContent));
    }
    #[Route('updatemedicamentsJson/{id}', name: 'app_medicaments_update')]
    public function updatemedicamentsJson(Request $req,$id,  NormalizerInterface $Normalizer, PharmacieRepository $pharmacieRepositry  )
    {
      $em = $this->getDoctrine()->getManager();
      $ph = $pharmacieRepositry->find($req->get('Pharmacie'));
      $medicaments = $em->getRepository(Medicament::class)->find($id);
      //$medicaments->addIdPharmacie($ph);

      $medicaments->setNom($req->get('Nom'));
      $medicaments->setType($req->get('Type'));
      $medicaments->setNbdose($req->get('Nb_dose'));
      $medicaments->setPrix($req->get('Prix'));
      $medicaments->setStock($req->get('Stock'));
      $em->persist($medicaments);
      $em->flush();
      $jsonContent = $Normalizer->normalize($medicaments, 'json',['groups'=>'medicaments']);
      return new Response(json_encode($jsonContent));
    }
    #[Route('deletemedicamentsJson/{id}', name: 'app_medicaments_delete')]
    public function deletemedicamentsJson(Request $req,$id,  NormalizerInterface $Normalizer)
    {
      $em = $this->getDoctrine()->getManager();
      $medicaments = $em->getRepository(Medicament::class)->find($id);
      $em->remove($medicaments);
      $em->flush();
      $jsonContent = $Normalizer->normalize($medicaments, 'json',['groups'=>'medicaments']);
      return new Response("Medicament est supprimier".json_encode($jsonContent));
    }*/


   // #[Route('/medicaments/new', name: 'app_medicament_new', methods: ['GET', 'POST'])]
   // public function newmedicaments(Request $request, MedicamentRepository $medicamentRepository, NormalizerInterface $normalizer)
   // {
      //  $em = $this ->getDoctrine()->getManager();
      //  $medicaments = new Medicaments();

        
   // }
    }

