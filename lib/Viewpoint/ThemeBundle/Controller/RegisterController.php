<?php

namespace Viewpoint\ThemeBundle\Controller;

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

class RegisterController extends AbstractController
{
    use AdminTrait;

    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $manager;
    private ValidatorInterface $validator;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $manager,
        ValidatorInterface $validator
    ) {
        $this->manager = $manager;
        $this->passwordHasher = $passwordHasher;
        $this->validator = $validator;
    }

    


    #[Route("/", name: "app_home")]
    public function home(ThemeResolver $themeResolver): Response
    {
        return $this->render($themeResolver->getThemePathPrefix("/core/home.html.twig"));
    }


    // #[Route("/room/detail", name: "app_room_detail")]
    // public function roomDetail(ThemeResolver $themeResolver): Response
    // {
        
    // }

    // #[Route("/rooms/create", name: "app_room_creation")]
    // public function roomCreation(ThemeResolver $themeResolver): Response
    // {
    //     return $this->render($themeResolver->getThemePathPrefix("/core/room-creation.html.twig"));
    // }

    // #[Route("/informations", name: "app_informations")]
    // public function informations(ThemeResolver $themeResolver): Response
    // {
    //     return $this->render(
    //         $themeResolver->getThemePathPrefix("/core/informations/contents/account.html.twig")
    //     );
    // }

    // #[Route("/informations/account", name: "app_informations_user")]
    // public function informationUser(ThemeResolver $themeResolver): Response
    // {
    //     return $this->render(
    //         $themeResolver->getThemePathPrefix("/core/informations/contents/account.html.twig")
    //     );
    // }

    #[Route("/informations/empty-message", name: "app_empty_message")]
    public function emptyMessage(ThemeResolver $themeResolver): Response
    {
        return $this->render(
            $themeResolver->getThemePathPrefix(
                "/core/informations/contents/empty-message.html.twig"
            )
        );
    }
    #[Route("/informations/empty-package", name: "app_empty_package")]
    public function emptyPackage(ThemeResolver $themeResolver): Response
    {
        return $this->render(
            $themeResolver->getThemePathPrefix(
                "/core/informations/contents/empty-package.html.twig"
            )
        );
    }
    #[Route("/informations/empty-order", name: "app_empty_order")]
    public function emptyOrder(ThemeResolver $themeResolver): Response
    {
        return $this->render(
            $themeResolver->getThemePathPrefix("/core/informations/contents/empty-order.html.twig")
        );
    }
    #[Route("/informations/rooms/visited", name: "app_user_room_visited")]
    public function emptyVu(ThemeResolver $themeResolver): Response
    {
        return $this->render(
            $themeResolver->getThemePathPrefix(
                "/core/informations/contents/empty-recently-seen.html.twig"
            )
        );
    }
    #[Route("/informations/empty-adresse", name: "app_adresse")]
    public function emptyAdresse(ThemeResolver $themeResolver): Response
    {
        return $this->render(
            $themeResolver->getThemePathPrefix(
                "/core/informations/contents/empty-adresse.html.twig"
            )
        );
    }
    #[Route("/informations/settings", name: "app_settings")]
    public function settings(ThemeResolver $themeResolver): Response
    {
        return $this->render(
            $themeResolver->getThemePathPrefix("/core/informations/contents/settings.html.twig")
        );
    }
    #[Route("/informations/package", name: "app_user_package")]
    public function package(ThemeResolver $themeResolver): Response
    {
        return $this->render(
            $themeResolver->getThemePathPrefix("/core/informations/contents/package.html.twig")
        );
    }
    
    #[Route("/TermsAndConditions", name: "app_terms_conditions")]
    public function ConditionsGenerales(ThemeResolver $themeResolver): Response
    {
        return $this->render(
            $themeResolver->getThemePathPrefix("/core/TermsAndConditions.html.twig")
        );
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact (ThemeResolver $themeResolver): Response
    {   
        return $this->render($themeResolver->getThemePathPrefix('/core/contact.html.twig'));
    }
}
