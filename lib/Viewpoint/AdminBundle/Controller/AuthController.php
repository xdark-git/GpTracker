<?php

namespace Viewpoint\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Viewpoint\AdminBundle\Traits\AdminTrait;
use Viewpoint\ThemeBundle\Service\ThemeResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\HttpFoundation\Request;
use Viewpoint\AdminBundle\Entity\Role;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Viewpoint\AdminBundle\Form\LoginFormType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthController extends AbstractController
{
    private ThemeResolver $themeResolver;
    private EntityManagerInterface $manager;
    public function __construct(ThemeResolver $themeResolver, EntityManagerInterface $manager)
    {
        $this->themeResolver = $themeResolver;
        $this->manager = $manager;
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
}
