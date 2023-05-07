<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\NewPasswordType;
use App\Form\ResetPasswordType;
use App\Form\VerificationCodeFormType;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\ForgetPasswordType;
use App\Form\ModifierImageType;
use App\Form\ModifierProfileType;
use Doctrine\Common\Collections\Collection;
use App\Form\VerifierProfileType;
use App\Repository\UserRepository;
use Doctrine\ORM\Events;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twilio\Rest\Client;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    #[Route(path: '/checkLogin', name: 'checkLogin')]
    public function login_check(UserRepository $userRepository ,LoginLinkHandlerInterface $loginLink,MailerInterface $mailer): Response
    {
        $users=$userRepository->findAll();
        foreach ($users as $user)
        {
            $LoginLinkDetails=$loginLink->createLoginLink($user);
            $email=(new \Symfony\Component\Mime\Email())
                ->from('muhamedabesy10@gmail.com')
                ->to($user->getEmail())
                ->subject('Login Check')
                ->text('verify link '.$LoginLinkDetails->getUrl());
            $mailer->send($email);
        }
        return new Response('checkLogin');
    }

    #[Route(path: '/forgetPassword', name: 'forgetPassword')]
    public function ForgetPassword(Request $request, UserRepository $user, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        $form = $this->createForm(ForgetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $donnees = $form->getData();
            $user = $user->findOneByEmail($donnees['email']);
            if ($user === null) {

                $this->addFlash('danger', 'Cette adresse e-mail est inconnue');
                return $this->redirectToRoute('login');
            }
            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('forgetPassword');
            }
            $url = $this->generateUrl('resetPassword', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
            $email = (new Email())
                ->from('tnsharedinc@gmail.com')
                ->to($user->getEmail())
                ->html( "Bonjour,<br><br>Une demande de réinitialisation de mot de passe a été effectuée pour le site Nouvelle-Techno.fr. Veuillez cliquer sur le lien suivant : ".$url);

            $mailer->send($email);
            return $this->redirectToRoute('login');
        }
        return $this->render('Security/forgetPassword.html.twig',
            ['emailForm' => $form->createView()]);
    }

    #[Route('modifierProfile/{id}', name: 'modifierProfile')]
    public function modifierProfile(ManagerRegistry $doctrine,$id,Request $req): Response {


        $em = $doctrine->getManager();
        $user = $doctrine->getRepository(User::class)->find($id);
        $form = $this->createForm(ModifierProfileType::class,$user);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em->persist($user);
            $em->flush();
            $roles=$user->getRoles();
            if(in_array('ROLE_MEDECIN', $roles)) {

                return $this->redirectToRoute('medecin');
            }
            if(in_array('ROLE_PATIENT', $roles)) {

                return $this->redirectToRoute('patient');
            }
        }

        return $this->renderForm('main/modifierProfile.html.twig',['form'=>$form]);

    }
    #[Route('modifierImage/{id}', name: 'modifierImage')]
    public function modifierImage(ManagerRegistry $doctrine,$id,Request $req,SluggerInterface $slugger,User $user,): Response {
        $form = $this->createForm(ModifierImageType::class,$user);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {

                /** @var UploadedFile $eventImage */
                $eventImage = $form->get('image')->getData();

            // this condition is needed because the 'eventImage' field is not required
            // so the Image file must be processed only when a file is uploaded
            if ($eventImage) {
                $originalFilename = pathinfo($eventImage->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $eventImage->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $eventImage->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'eventImage' property to store the image file name
                // instead of its contents
                $user->setImage($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();
            $roles=$user->getRoles();
            if(in_array('ROLE_MEDECIN', $roles)) {

                return $this->redirectToRoute('medecin', [], Response::HTTP_SEE_OTHER);
            }
            if(in_array('ROLE_PATIENT', $roles)) {

                return $this->redirectToRoute('patient', [], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->renderForm('main/modifierImage.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);



    }
    #[Route('verifierProfile/{id}', name: 'verifierProfile')]
    public function verifierProfile(ManagerRegistry $doctrine,$id,Request $req): Response {


        $em = $doctrine->getManager();
        $user = $doctrine->getRepository(User::class)->find($id);
        $form = $this->createForm(VerifierProfileType::class,$user);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em->persist($user);
            $em->flush();
            $roles=$user->getRoles();

                return $this->redirectToRoute('medecin');


        }

        return $this->renderForm('main/verifierProfile.html.twig',['form'=>$form]);

    }
    #[Route('deleteAccount/{id}', name: 'deleteAccount')]
    public function deleteAccount(ManagerRegistry $doctrine,$id): Response
    {
        $em= $doctrine->getManager();
        $user= $doctrine->getRepository(User::class)->find($id);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('home');
    }
    #[Route('banPatient/{id}', name: 'banPatient')]
    public function banAccount(ManagerRegistry $doctrine,$id): Response
    {
        $em= $doctrine->getManager();
        $user= $doctrine->getRepository(User::class)->find($id);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('listPatient');
    }

    /**
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     * @throws \Exception
     */
    #[Route(path: '/resetPassword', name: 'resetPassword')]
    public function resetPassword(Request $request, UserRepository $user, TokenGeneratorInterface $tokenGenerator): Response
    {
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $donnees = $form->getData();


            $recevier= $user->findOneByNumero($donnees->getNumero());
            $idsms = $recevier->getId();
            $tokensalt = bin2hex(random_bytes(2));

            try {
                $recevier->setResetToken($tokensalt);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($recevier);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());

                return $this->redirectToRoute('resetPassword');
            }
            $sid = 'ACe0d39e374a4b33c50217f1c834d14a13';
            $token = '5e930d060e34882e4131bc1600ad5248';
            $client = new Client($sid, $token);

            $client->messages->create(
            // the number you'd like to send the message to
                $recevier->getNumero(),
                [
                    // A Twilio phone number you purchased at twilio.com/console
                    'from' => '+15076093506',
                    // the body of the text message you'd like to send
                    'body' => 'Your reset token is :' .$tokensalt
                ]
            );

            return $this->redirectToRoute('code_app',['idsms' => $idsms]);
        }
        return $this->render('main/resetPassword.html.twig',
            ['emailForm' => $form->createView()]);
    }
    #[Route(path: '/verificationCode/{idsms}', name: 'code_app')]
    public function VerificationCode(Request $request, UserRepository $user,ManagerRegistry $doctrine,$idsms): Response
    {

        $form = $this->createForm(VerificationCodeFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $donnees = $form->getData();
            $recevier= $user->findOneBySalt($donnees->getResetToken());

            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($recevier);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());

                return $this->redirectToRoute('resetPassword');
            }

            return $this->redirectToRoute('newPassword',['idsms' => $idsms]);
        }
        return $this->render('main/verificationCode.html.twig',
            ['emailForm' => $form->createView()]);
    }
    #[Route('newPassword/{idsms}', name: 'newPassword')]
    public function newPassword(ManagerRegistry $doctrine,$idsms,Request $req , UserPasswordHasherInterface $userPasswordHasher): Response {

        $em = $doctrine->getManager();
        $user = $doctrine->getRepository(User::class)->find($idsms);
        $form = $this->createForm(NewPasswordType::class,$user);
        $form->handleRequest($req);
        if($form->isSubmitted())
        {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('login');

        }

        return $this->renderForm('main/newPassword.html.twig',['form'=>$form]);

    }


}
