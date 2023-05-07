<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Like;
use App\Entity\Likes;
use App\Form\EvenementType;
use App\Form\UpdateEvType;
use App\Repository\EvenementRepository;
use App\Repository\LikeRepository;
use App\Repository\LikesRepository;
use App\Repository\UserRepository;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
  
    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('back_office/evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }
    #[Route('/events', name: 'app_evenement_index_front', methods: ['GET'])]
    public function frontindex(EvenementRepository $evenementRepository): Response
    {
        return $this->render('events/list.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }
    #[Route('/events/like/{id}', name: 'app_evenement_like', methods: ['GET'])]
    public function like(
        Request $request, 
          EvenementRepository $evenementRepository,
          
          LikeRepository $likeRepository
    ): Response
    {
        $event = $evenementRepository->find( $request->attributes->get("id"));
        $userp = $this->getUser();
        $like = new Like();
        $like->setEvent($event);
        $like->setUser($userp);
        $likeRepository->save($like, true); 
        $event->addLike($like); 
        $evenementRepository->save($event , true );
        return $this->redirectToRoute('app_evenement_index_front', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }
    #this is like section 
    #[Route('/events/{id}/likes', name: 'app_evenement_getlikes', methods: ['GET'])]
    public function getLikes(
          Request $request, 
          EvenementRepository $evenementRepository, 
          LikeRepository $likeRepository
    ): Response
    {
        $event = $evenementRepository->find( $request->attributes->get("id")); 
        $like= $likeRepository->find($event); 
        return $this->redirectToRoute('app_evenement_index_front', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    #[Route('/details', name: 'app_evenement_index_front_details', methods: ['GET'])]
    public function frontindexx(EvenementRepository $evenementRepository): Response
    {

        return $this->render('main/details.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EvenementRepository $evenementRepository ,
        UserRepository $userRepository , 
        MailerInterface $mailer,SluggerInterface $slugger): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                /** @var UploadedFile $eventImage */
            $eventImage = $form->get('image')->getData();

            // this condition is needeecord because the 'eventImage' field is not required
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
                $evenement->setImage($newFilename);
            }  

            $evenementRepository->save($evenement, true); 
           //get all users
            $allUsers = $userRepository->findAll();
            // notify each user with email
            foreach ($allUsers as   $value) {
                $email = (new Email())
                ->from('symfonyttester@gmail.com')
                ->to($value->getEmail()) 
                ->subject('New EVENT !')
                ->html('<p>We  are happy to let you know  that we added '.$evenement->getNom().' <br> location : '.$evenement->getLocal().' <br> we are waiting!</p>');
                $mailer->send($email);
                      }
            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back_office/evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        
        return $this->render('back_office/evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }
    #[Route('/user/{id}', name: 'app_evenement_show_front', methods: ['GET'])]
    public function showf(Evenement $evenement): Response
    { 
        return $this->render('events/eventDetails.html.twig', [
            'evenement' => $evenement,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
         Evenement $evenement,
          EvenementRepository $evenementRepository,
          UserRepository $userRepository,
          MailerInterface $mailer): Response
    {
        $form = $this->createForm(UpdateEvType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            
            $evenementRepository->save($evenement, true);

             //get all users
             $allUsers = $userRepository->findAll();
             // notify each user with email
             foreach ($allUsers as   $value) {
                 $email = (new Email())
                 ->from('symfonyttester@gmail.com')
                 ->to($value->getEmail()) 
                 ->subject('EVENT '.$evenement->getNom().' updated')
                 ->html('<p>We  want to let you know  that we updated '.$evenement->getNom().' <br> go check it!</p>');
                 $mailer->send($email);
                       }

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back_office/evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_evenement_delete', methods: ['GET'])]
    public function delete(
        Request $request,
         Evenement $evenement,
          EvenementRepository $evenementRepository , 
          UserRepository $userRepository,
          MailerInterface $mailer): Response
    {
         
            
            if($evenement->getParticipations()!= null){
            foreach ($evenement->getParticipations() as   $value) {
                $email = (new Email())
                ->from('symfonyttester@gmail.com')
                ->to($userRepository->find($value->getUserId())->getEmail() ) 
                ->subject('EVENT '.$evenement->getNom().' Canceled')
                ->html('<p>We  want to let you know  that we canceled '.$evenement->getNom().' </p>');
                
                $mailer->send($email);
                      }
                    }
                    $evenementRepository->remove($evenement, true);
        return $this->render('back_office/evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
        
}





}