<?php

namespace Viewpoint\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Viewpoint\ThemeBundle\Service\ThemeResolver;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    private ThemeResolver $themeResolver;
    public function __construct(ThemeResolver $themeResolver)
    {
        $this->themeResolver = $themeResolver;
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
