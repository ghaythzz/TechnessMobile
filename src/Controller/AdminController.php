<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Speciality;
use App\Entity\User;
use App\Form\AdminApproveType;
use App\Form\BanType;
use App\Form\ClassroomType;
use App\Form\SpecialityType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('adminApprove/{id}', name: 'adminApprove')]
    public function adminApprove(ManagerRegistry $doctrine,$id,Request $req): Response
    {
        $em = $doctrine->getManager();
        $user = $doctrine->getRepository(User::class)->find($id);
        $users = $doctrine->getRepository(User::class)->find($id);
        $form = $this->createForm(AdminApproveType::class,$user);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em->persist($user);
            $em->flush();
            $roles=$user->getRoles();

            return $this->redirectToRoute('listMedecin');

        }
        return $this->renderForm('back_office/security/adminApprove.html.twig',[
            'users' => $users,
            'form'=>$form
        ]);

    }

    #[Route('/speciality', name: 'speciality')]
    public function speciality(ManagerRegistry $doctrine): Response
    {
        $speciality= $doctrine->getRepository(Speciality::class)->findAll();
        return $this->render('back_office/security/listSpeciality.html.twig', [
            'speciality' => $speciality,
        ]);
    }
    #[Route('addSpeciality', name: 'addSpeciality')]
    public function addSpeciality(ManagerRegistry $doctrine,Request $req): Response {
        $em = $doctrine->getManager();
        $speciality = new Speciality();
        $form = $this->createForm(SpecialityType::class,$speciality);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em->persist($speciality);
            $em->flush();
            return $this->redirectToRoute('speciality');
        }
        //$club->setName('club test persist');
        //$club->setCreationDate(new \DateTime());
        return $this->renderForm('back_office/security/addSpeciality.html.twig',['form'=>$form]);
    }
    #[Route('deleteSpeciality/{id}', name: 'deleteSpeciality')]
    public function deleteSpeciality(ManagerRegistry $doctrine,$id): Response
    {
        $em= $doctrine->getManager();
        $S= $doctrine->getRepository(Speciality::class)->find($id);
        $em->remove($S);
        $em->flush();
        return $this->redirectToRoute('speciality');
    }
    #[Route('updateSpeciality/{id}', name: 'updateSpeciality')]
    public function updateSpeciality(ManagerRegistry $doctrine,$id,Request $req): Response {
        $em = $doctrine->getManager();
        $speciality = $doctrine->getRepository(Speciality::class)->find($id);
        $form = $this->createForm(SpecialityType::class,$speciality);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em->persist($speciality);
            $em->flush();
            return $this->redirectToRoute('speciality');
        }
        return $this->renderForm('back_office/security/addSpeciality.html.twig',['form'=>$form]);

    }
    #[Route('adminBan/{id}', name: 'adminBan')]
    public function adminBan(ManagerRegistry $doctrine,$id,Request $req): Response
    {
        $em = $doctrine->getManager();
        $user = $doctrine->getRepository(User::class)->find($id);
        $users = $doctrine->getRepository(User::class)->find($id);
        $form = $this->createForm(BanType::class,$user);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em->persist($user);
            $em->flush();
            $roles=$user->getRoles();

            return $this->redirectToRoute('listMedecin');

        }
        return $this->renderForm('back_office/security/adminBan.html.twig',[
             'form'=>$form,
            'users' => $users
        ]);

    }
    #[Route('adminUnban/{id}', name: 'adminUnban')]
    public function adminUnban(ManagerRegistry $doctrine,$id,Request $req): Response
    {
        $em = $doctrine->getManager();
        $user = $doctrine->getRepository(User::class)->find($id);
            $user->setBaned(null);
            $em->persist($user);
            $em->flush();
        return $this->redirectToRoute('listMedecin');
    }
}
