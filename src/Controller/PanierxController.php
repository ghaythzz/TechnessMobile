<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MedicamentRepository;
use App\Controller\PanierxType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use App\Entity\Medicament;
use App\Repository\PanierxRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\Panierx;
use Doctrine\Persistence\ManagerRegistry;

use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Bridge\Doctrine\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\EmailService;
use App\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter; 

class PanierxController extends AbstractController
{
    #[Route('/shop', name: 'app_panierx')]
   
    public function index(Request $request ,MedicamentRepository $medicamentRepository,EntityManagerInterface $entityManager): Response
    {
        $name = $request->request->get('searchTerm');

        $somme = $entityManager->createQueryBuilder()
        ->select('SUM(p.qte)')
        ->from('App\Entity\Panierx', 'p')
        ->getQuery()
        ->getSingleScalarResult();
        return $this->render('panierx/search.html.twig', [
            'medicaments' => $medicamentRepository->findAll(),
            'qte'=>$somme,
            'searchTerm' => $name

        ]);
    }
    
 
    
    //ajouter au panier
    #[Route('/panierx/new/{id}', name: 'app_panierx_new', methods: ['GET', 'POST'])]
  
    public function new(FlashyNotifier $flashy,Request $request,EntityManagerInterface $entityManager, Medicament $medicament,Security $security, panierxRepository $panierxRepository, ): Response
    
    { 
      $id_medica=$medicament->getId();
        $user = $security->getUser();
        $prix = $medicament->getPrix();
        $panierxRepository = $entityManager->getRepository(panierx::class);
        $panier = $panierxRepository->findBy(['id_user' => $user, 'id_medica'=>$id_medica] ); 
        if ($panier){
            $panier = $panier[0];
            $x = $panier->getQte();
            $panier->setQte($x+1);
            $panierxRepository->save($panier, true);
            //$flashy->success('Medicament ajouté!', 'http://your-awesome-link.com');
            $flashy->success('Médicament ajouté au panier avec succès!', 'http://your-awesome-link.com');

            return $this->redirectToRoute('app_panierx', [], Response::HTTP_SEE_OTHER);        

        }
        else{

        $panierx = new Panierx();


            //SETTERS
         $panierx-> setIdMedica($medicament);
         $panierx->setIdUser($user);
         $panierx->setPrix($prix) ;
         $panierx->setQte('1') ;
         $panierxRepository->save($panierx, true);
         //$flashy->success('Médicament ajoutée!', 'http://your-awesome-link.com');
         $flashy->success('Médicament ajouté au panier avec succès!', 'http://your-awesome-link.com');

         return $this->redirectToRoute('app_panierx', [], Response::HTTP_SEE_OTHER);        
     
        }
    }
        #[Route('/search', name: 'search_medicament_page')]
        public function findMedicament(Request $request) :Response
        {
            $name = $request->request->get('searchTerm');
            
    
            if (!$name) {
                $medicaments = $this->getDoctrine()->getRepository(Medicament::class)->findAll();
            } else {
                $medicaments = $this->getDoctrine()->getRepository(Medicament::class)->findMedicament($name);
            }
    
    
            return $this->render('panierx/search.html.twig', [
                'medicaments' => $medicaments,
                'searchTerm' => $name
            ]);
        }

        #[Route('/searchquery', name: 'search_medicament')]
    public function findmedicaments(Request $request): Response
    {
        $name = $request->request->get('searchTerm');

        if (!$name) {
            $medicaments = $this->getDoctrine()->getRepository(Medicament::class)->findAll();
        } else {
            $medicaments = $this->getDoctrine()->getRepository(Medicament::class)->findMedicament($name);
        }

        $tableHtml = $this->renderView('panierx/_table.html.twig', [
            'medicaments' => $medicaments,
            'searchTerm' => $name
        ]);

        return new Response($tableHtml);

    }
    

// Affichage panierx 


// #[Route('/show', name: 'app_panier_show', methods: ['GET'])]
// public function show(PanierxRepository $panierxRepository,): Response
// {
   
//     return $this->render('panierx/show.html.twig', [
//         'panierx' => $panierxRepository->findAll(),
//     ]);
// }
#[Route('/show', name: 'app_panier_show')]
    public function show(ManagerRegistry $doctrine,PaginatorInterface $paginator,Request $request): Response
    {  
        $panierx= $doctrine->getRepository(Panierx::class)->findAll(); 

        $pagination = $paginator->paginate(
            $panierx,
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('panierx/show.html.twig', [
            'panierx' => $pagination,
            
        ]);
    }
    #[Route('/{id}/delete', name: 'app_panier_delete', methods: ['GET','POST'])]
    public function delete(FlashyNotifier $flashy,Security $security,Request $request, PanierxRepository $panierxRepository): Response
{
    $id = $request->attributes->get('id');
    $panierx = $panierxRepository->find($id);

    if (!$panierx) {
        throw $this->createNotFoundException('Le panier n\'existe pas.');
    }

    $panierxRepository->delete($panierx);
    

    $flashy->error('Medicament est supprimier ', 'http://your-awesome-link.com');
    

    return $this->redirectToRoute('app_panier_show');
}

public function rechercheBynamemedAction(Request $request, Panierx $panierx)
{
    $em = $this->getDoctrine()->getManager();
    if ($request->isMethod('POST')) {
        $id_medica = $request->get('nom');
        $panierx = $em->getRepository(Panierx::class)->createQueryBuilder('p')
            ->leftJoin('p.id_medica', 'm')
            ->where('m.nom = :id_medica')
            ->setParameter('id_medica', $id_medica)
            ->getQuery()
            ->getResult();
    }
    return $this->render('panierx/index.html.twig', [
        'panierx' => $panierx,
    ]);
}






}


    // #[Route('/{id}/delete', name: 'app_panier_delete', methods: ['GET','POST'])]
    // public function effacer(Request $request, Panierx $panierx, PanierxRepository $panierxRepository): Response
    // {
    //         $panierxRepository->remove($panierx, true);

    //     return $this->redirectToRoute('app_panier_delete', [], Response::HTTP_SEE_OTHER);
        
    // }

