<?php

namespace App\Controller;

use App\Entity\User;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
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
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
class SecurityControllerApi extends AbstractController
{
    #[Route('/loginApi', name: 'loginApi')]

    public function login(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $email = $request->query->get("email");
        $password = $request->query->get("password");

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        dump($user);
        $validPassword = $userPasswordHasher->isPasswordValid($user, $password);
        if ($user) {
            if ($validPassword) {
                $normalizer = new ObjectNormalizer();
                $serializer = new \Symfony\Component\Serializer\Serializer(array(new DateTimeNormalizer(), $normalizer));
                $formatted = $serializer->normalize($user,null,array('attributes' => array(
                    'id', 'nom', 'prenom', 'email','numero','adresse')));
                return new JsonResponse($formatted);
            } else {
                return new JsonResponse(['error' => "Wrong Password"], 403);
            }
        } else {
            return new JsonResponse(['error' => "Please verify your username or password"], 403);
        }
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

}
