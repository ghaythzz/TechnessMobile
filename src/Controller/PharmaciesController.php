<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PharmacieRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Pharmacie;
use Symfony\Component\HttpFoundation\JsonResponse;



class PharmaciesController extends AbstractController
{
  
  #[Route('/pharmacies', name: 'app_pharmacies')]
  public function pharmacies(PharmacieRepository $pharmacieRepository ,SerializerInterface $serializer )
  {
      $pharmacies = $pharmacieRepository->findAll();
      //dump($medicaments);
      //die;
     // $medicamentsNormalises = $normalizer->normalize($medicaments,'json' ,['groups' =>"medicaments"]);
     //  $json = json_encode($medicamentsNormalises);
      $json = $serializer-> serialize($pharmacies, 'json' , ['groups' => "pharmacies"]);
     
      return new Response($json);

        }
  
        #[Route('/pharmacies/{id}', name: 'app_pharmacies_show')]
    public function pharmaciessid($id, NormalizerInterface $normalizer , PharmacieRepository $repo)
    {
      $pharmacies=$repo->find($id);
      $pharmaciesNormalises = $normalizer->normalize($pharmacies,'json' ,['groups' =>"pharmacies"]);
      return new Response(json_encode($pharmaciesNormalises));

  }
  #[Route('addpharmaciesJson/new', name: 'app_pharmacies_new',methods: ['POST'])]
  public function addpharmaciesJson(Request $req, NormalizerInterface $Normalizer)
  {
    $em = $this->getDoctrine()->getManager();
    $pharmacies = new Pharmacie();
    $pharmacies->setNom($req->get('Nom'));
    //dump($medicaments);
    //die();
    $pharmacies->setAdresse($req->get('Adresse'));
    $pharmacies->setTempo($req->get('Tempo'));
    $pharmacies->settempf($req->get('tempf'));

    $em->persist($pharmacies);
    $em->flush();
    $jsonContent = $Normalizer->normalize($pharmacies, 'json',['groups'=>'pharmacies']);
    return new Response(json_encode($jsonContent));
  }
  #[Route('updatepharmaciesJson/{id}', name: 'app_pharmacies_update')]
  public function updatepharmaciesJson(Request $req,$id,  NormalizerInterface $Normalizer  )
  {
    $em = $this->getDoctrine()->getManager();
    $pharmacies = $em->getRepository(Pharmacie::class)->find($id);
    $pharmacies->setAdresse($req->get('Adresse'));
    $pharmacies->setTempo($req->get('Tempo'));
    $pharmacies->settempf($req->get('tempf'));
    $em->persist($pharmacies);
    $em->flush();
    $jsonContent = $Normalizer->normalize($pharmacies, 'json',['groups'=>'pharmacies']);
    return new Response(json_encode($jsonContent));
  }
  #[Route('deletepharmaciesJson/{id}', name: 'app_pharmacies_delete')]
  public function deletepharmaciesJson(Request $req,$id,  NormalizerInterface $Normalizer)
  {
    $em = $this->getDoctrine()->getManager();
    $pharmacies = $em->getRepository(Pharmacie::class)->find($id);
    $em->remove($pharmacies);
    $em->flush();
    $jsonContent = $Normalizer->normalize($pharmacies, 'json',['groups'=>'pharmacies']);
    return new Response("ph suppri".json_encode($jsonContent));
  }
    
}
