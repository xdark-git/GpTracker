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

    #[Route('/rooms', name: 'app_rooms')]
    public function rooms (ThemeResolver $themeResolver): Response
    {   
        return $this->render($themeResolver->getThemePathPrefix('/core/rooms.html.twig'));
    }

    #[Route("/informations", name:"app_informations")]
    public function informations(ThemeResolver $themeResolver): Response
    {
        return $this->render($themeResolver->getThemePathPrefix('/core/informations/contents/account.html.twig'));
    }

    #[Route("/informations/account", name:"app_informations_user")]
    public function informationUser(ThemeResolver $themeResolver): Response
    {
        return $this->render($themeResolver->getThemePathPrefix('/core/informations/contents/account.html.twig'));
    }
    
    #[Route("/informations/empty-message", name:"app_empty_message")]
    public function emptyMessage (ThemeResolver $themeResolver): Response
    {
        return $this->render($themeResolver->getThemePathPrefix('/core/informations/contents/emptyMessage.html.twig'));
    }
    #[Route("/informations/empty-package", name:"app_empty_package")]
    public function emptyPackage (ThemeResolver $themeResolver): Response
    {
        return $this->render($themeResolver->getThemePathPrefix('/core/informations/contents/emptyPackage.html.twig'));
    }
    #[Route("/informations/empty-order", name:"app_empty_order")]
    public function emptyOrder (ThemeResolver $themeResolver): Response
    {
        return $this->render($themeResolver->getThemePathPrefix('/core/informations/contents/emptyOrder.html.twig'));
    }
}
