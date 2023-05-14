<?php 

namespace Viewpoint\ThemeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Viewpoint\ThemeBundle\Service\ThemeResolver;

class RegisterController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login (ThemeResolver $themeResolver): Response
    {   
        return $this->render($themeResolver->getThemePathPrefix('/core/login.html.twig'));
    }
    #[Route('/register', name: 'app_register')]
    public function register (ThemeResolver $themeResolver): Response
    {   
        return $this->render($themeResolver->getThemePathPrefix('/core/register.html.twig'));
    }
    #[Route('/', name: 'app_home')]
    public function home (ThemeResolver $themeResolver): Response
    {   
        return $this->render($themeResolver->getThemePathPrefix('/core/home.html.twig'));
    }
    #[Route('/contact', name: 'app_home')]
    public function contact (ThemeResolver $themeResolver): Response
    {   
        return $this->render($themeResolver->getThemePathPrefix('/core/contact.html.twig'));
    }
}