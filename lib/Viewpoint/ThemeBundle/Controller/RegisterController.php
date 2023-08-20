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

    #[Route("/informations/empty-message", name: "app_empty_message")]
    public function emptyMessage(ThemeResolver $themeResolver): Response
    {
        return $this->render(
            $themeResolver->getThemePathPrefix(
                "/core/informations/contents/empty-message.html.twig"
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
    
    #[Route("/informations/empty-adresse", name: "app_adresse")]
    public function emptyAdresse(ThemeResolver $themeResolver): Response
    {
        return $this->render(
            $themeResolver->getThemePathPrefix(
                "/core/informations/contents/empty-adresse.html.twig"
            )
        );
    }
    
    #[Route("/terms-and-conditons", name: "app_terms_conditions")]
    public function ConditionsGenerales(ThemeResolver $themeResolver): Response
    {
        return $this->render(
            $themeResolver->getThemePathPrefix("/core/terms_and_conditions.html.twig")
        );
    }
}