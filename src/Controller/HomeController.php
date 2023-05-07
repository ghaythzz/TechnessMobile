<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
        #[Route('/', name: 'index')]
        public function index(): Response
        {
            return $this->redirectToRoute('home');
        }

        #[Route('/home', name: 'home')]
        public function home(): Response
        {
            return $this->render('main/homeGuest.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }
    #[Route('/homeAdmin', name: 'homeAdmin')]
    public function homeAdmin(): Response
    {
        return $this->render('back_office/homeAdmin.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/homePatient', name: 'homePatient')]
    public function homePatient(): Response
    {
        return $this->render('main/homePatient.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/homeMedecin', name: 'homeMedecin')]
    public function homeMedecin(): Response
    {
        if($this->getUser()->getBaned()!= null)
        {
            return $this->render('main/baned.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }
        return $this->render('main/homeMedecin.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/baned', name: 'baned')]
    public function baned(): Response
    {
        return $this->render('main/baned.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/medecin', name: 'medecin')]
    public function medecin(): Response
    {
        if($this->getUser()->getBaned()!= null)
        {
            return $this->render('main/baned.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }
        return $this->render('main/medecin.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/patient', name: 'patient')]
    public function patient(): Response
    {
        return $this->render('main/patient.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/resetPassword/{token}', name: 'resetPassword')]
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);
        dump($token);
        dump($user);
        if ($user === null) {
            $this->addFlash('danger', 'Token Inconnu');
            return $this->redirectToRoute('login');
        }
        if ($request->isMethod('POST')) {

            $user->setResetToken("");
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            $this->addFlash('message', 'Mot de passe mis à jour');
            return $this->redirectToRoute('login');
        } else {
            return $this->render('security/resetPassword.html.twig', ['token' => $token]);
        }


    }

    #[Route('/listPatient', name: 'listPatient')]
    public function listPatient(ManagerRegistry $doctrine): Response
    {


        $user= $doctrine->getRepository(User::class)->findAll();
         return $this->render('back_office/Security/listPatient.html.twig', [
            'user' => $user,

        ]);
    }

    #[Route('/listMedecin', name: 'listMedecin')]
    public function listMedecin(ManagerRegistry $doctrine): Response
    {

        $em = $doctrine->getManager();

        $users= $doctrine->getRepository(User::class)->findAll();

        foreach ($users as $user)
        {
            $progress =24 ;
            if(!empty($user->getBioDescription()))
            {
                $progress = $progress + 12.5 ;
            }
            if(!empty($user->getNumero()))
            {
                $progress = $progress + 12.5 ;

            }
            if(!empty($user->getAdresse()))
            {
                $progress = $progress + 12.5 ;

            }
            if(!empty($user->getImage()))
            {
                $progress = $progress + 12.5 ;

            }
            if(!empty($user->getSpeciality()))
            {
                $progress = $progress + 12.5 ;

            }
            if(!empty($user->getLicenceNumero()))
            {
                $progress = $progress + 12.5 ;

            }
            if(!empty($user->isStatus()))
            {
                $progress = 100 ;

            }
            $user->setProgress($progress);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render('back_office/Security/listMedecin.html.twig', [
            'user' => $users,

        ]);
    }

}
