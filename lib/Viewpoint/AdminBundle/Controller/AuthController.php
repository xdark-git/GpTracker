<?php

namespace Viewpoint\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Viewpoint\ThemeBundle\Service\ThemeResolver;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Viewpoint\AdminBundle\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Viewpoint\AdminBundle\Entity\User;
use Viewpoint\AdminBundle\Repository\UserRepository;
use App\Form\RegistrationFormType;
use Viewpoint\AdminBundle\Entity\Role;
use Symfony\Bundle\SecurityBundle\Security;

class AuthController extends AbstractController
{
    private ThemeResolver $themeResolver;
    private EmailVerifier $emailVerifier;
    private Security $security;
    public function __construct(ThemeResolver $themeResolver, EmailVerifier $emailVerifier, Security $security)
    {
        $this->themeResolver = $themeResolver;
        $this->emailVerifier = $emailVerifier;
        $this->security = $security;
    }

    #[Route("/login", name: "app_login")]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render($this->themeResolver->getThemePathPrefix("/core/login.html.twig"), [
            // "loginForm" => $form->createView(),
            "last_username" => $lastUsername,
            "error" => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            $roleUser = $entityManager->getRepository(Role::class)->findOneBy(['name'=> 'ROLE_USER']);
            // encode the plain password
            $user
                ->setRole($roleUser)
                ->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('noreply@your-domain.com', 'GP-Tracker'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
                );
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render($this->themeResolver->getThemePathPrefix("/core/register.html.twig"), [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, UserRepository $userRepository, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator)    : Response
    {
        $id = $request->query->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        $currentUser = $this->security->getUser();
        
        if(!$currentUser){
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        if($currentUser === $user){
            return $this->redirectToRoute('app_home');
        }

        if($currentUser !== $user){
            //logout the current user and login verified user
            $this->security->logout(false);

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }


        return $this->redirectToRoute('app_home');
    }
}
