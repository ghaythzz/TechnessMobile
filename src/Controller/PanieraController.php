<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Panierx;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Pan;

use App\Entity\Medicament;
use App\Entity\User;
use App\Repository\MedicamentRepository;
use App\Repository\PanierxRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PanRepository;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use function PHPSTORM_META\type;

class PanieraController extends AbstractController
{
    #[Route('/pan', name: 'app_paniera')]
    public function paniera(PanRepository $panRepository ,SerializerInterface $serializer )
    {
        $pan = $panRepository->findAll();
       
        //dump($medicaments);
        //die;
       // $medicamentsNormalises = $normalizer->normalize($medicaments,'json' ,['groups' =>"medicaments"]);
       //  $json = json_encode($medicamentsNormalises);
        $json = $serializer-> serialize($pan, 'json' , ['groups' => "pan"]);
       
        return new Response($json);
  
          }
          #[Route('/pan/{id}', name: 'pan_show')]
          public function show(Pan $pan, $id, NormalizerInterface $normalizer, PanRepository $repo,PanRepository $panRepository)
          {
            $pan = $panRepository->find($id);
            $panNormalises = $normalizer->normalize($pan,'json' ,['groups' =>"pan"]);
            return new Response(json_encode($panNormalises));
          }


          #[Route('/create', name: 'app_pan_new',methods: ['POST'])]
          public function addpanJson(Request $req, NormalizerInterface $Normalizer)
          {
              $em = $this->getDoctrine()->getManager();
              $pan = new Pan();
             // $pan->setId($req->get('id'));
             //$pan = $req->get('nom');
              $pan->setNom($req->get('nom'));
              $pan->setTotalprix($req->get('totalprix'));
              $em->persist($pan);
              $em->flush();
              $jsonContent = $Normalizer->normalize($pan, 'json',['groups'=>'pan']);
              return new Response(json_encode($jsonContent));
          }
    #[Route('updatepanJson/{id}', name: 'app_pan_update')]
    public function updatepanJson($id,Request $req, NormalizerInterface $Normalizer , PanRepository $panRepository  )
    {
        $em = $this->getDoctrine()->getManager();
        $pan= new Pan();
    $pan->settotalprix($req->get('totalprix'));
    
    $em->persist($pan);
    $em->flush();
    $jsonContent = $Normalizer->normalize($pan, 'json',['groups'=>'pan']);
    return new Response(json_encode($jsonContent));
    }


    #[Route('/deletepanJson/{id}', name: 'app_pan_delete',methods: ['DELETE'])]

    public function deletemedicamentsJson(Request $req,$id,  NormalizerInterface $Normalizer)
    {
      $em = $this->getDoctrine()->getManager();
      $pan = $em->getRepository(Pan::class)->find($id);
      $em->remove($pan);
      $em->flush();
      $jsonContent = $Normalizer->normalize($pan, 'json',['groups'=>'pan']);
      return new Response("Medicament est supprimier".json_encode($jsonContent));
    }
}

        //ajoy  
    //     #[Route('addpaniraJson/new', name: 'app_paniera_new',methods: ['POST'])]

    //       public function newJson( EntityManagerInterface $entityManager,Request $req, NormalizerInterface $Normalizer)
    
    // { 
    //     $em = $this->getDoctrine()->getManager();

    //     $paniera = new Panierx();
    //     //$medicamentId = $req->get('medicament');
    //     $medicamentId = 3;
    //     $medicament = $em->getRepository(Medicament::class)->find($medicamentId);
    //     if (!$medicament) {
    //         throw $this->createNotFoundException('No medicament found for id '.$medicamentId);
    //     }
    //    // $userId = $req->get('id_user',Panierx::class);
    //    $userId = intval($req->get('id_user'));

         
    //     //$userId =2;
    //     $user = $em->getRepository(User::class)->find($userId);

    //     $prix = $req->get('prix');
    //     $qte = $req->get('qte');


    //     $paniera->setIdMedica($req->get('medicament'));
    //     $paniera->setIdUser($req->get('user'));
    //     $paniera->setPrix($req->get('prix'));
    //     $paniera->setQte($req->get('qte'));


    //     $em->persist($paniera);
    //     $em->flush();
    //     dump($paniera);
        
    //     die();

    //     $jsonContent = $Normalizer->normalize($paniera, 'json', ['groups' => 'panier']);
    //     return new JsonResponse($jsonContent);
    // }
    //         }


