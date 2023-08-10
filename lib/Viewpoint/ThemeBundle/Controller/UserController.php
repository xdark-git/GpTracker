<?php

namespace Viewpoint\ThemeBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Viewpoint\AdminBundle\Form\ProfileCompletionType;
use Viewpoint\ThemeBundle\Service\ThemeResolver;

class UserController extends AbstractController
{

    public function __construct(Private EntityManagerInterface $entityManager)
    {
        
    }
    #[Route("/informations", name: "app_informations")]
    #[Route("/informations/account", name: "app_informations_user")]
    public function completeProfile(Request $request, ThemeResolver $themeResolver): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileCompletionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $profileImageFile */
            $profileImageFile = $form->get("profile")->getData();
            if ($profileImageFile) {
                $destination = $this->getParameter("kernel.project_dir") . "/public/uploads/user_profile";
                $originalFileName = pathinfo(
                    $profileImageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $newFileName =
                    "user-" .
                    uniqid() .
                    "-" .
                    Urlizer::urlize($originalFileName) .
                    ".".
                    $profileImageFile->guessExtension();

                $profileImageFile->move($destination, $newFileName);

                $user->setProfile($newFileName);
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            
            $this->addFlash("success", "Profil complété avec succès !");
        }

        return $this->render(
            $themeResolver->getThemePathPrefix("/core/informations/contents/account.html.twig"),
            [
                "profileCompletionForm" => $form->createView(),
            ]
        );
    }

    #[Route("/activation", name: "app_account_activation")]
    public function accountActivation(ThemeResolver $themeResolver): Response
    {
        return $this->render(
            $themeResolver->getThemePathPrefix("/core/email_verification.html.twig")
        );
    }
}
