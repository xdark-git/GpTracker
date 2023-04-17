<?php 

namespace Viewpoint\ThemeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login (): Response
    {
        return $this->render('@ViewpointTheme/cms/login.html.twig');
    }
}