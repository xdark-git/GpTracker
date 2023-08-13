<?php

namespace Viewpoint\ThemeBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Viewpoint\ThemeBundle\Form\ChangePasswordFormType;
use Viewpoint\AdminBundle\Form\ProfileCompletionType;
use Viewpoint\ThemeBundle\Service\ThemeResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Viewpoint\AdminBundle\Entity\User;

class UserController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    #[Route("/informations", name: "app_informations")]
    #[Route("/informations/account", name: "app_informations_user")]
    public function completeProfile(Request $request, ThemeResolver $themeResolver): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(ProfileCompletionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $profileImageFile */
            $profileImageFile = $form->get("profile")->getData();
            if ($profileImageFile) {
                $destination =
                    $this->getParameter("kernel.project_dir") . "/public/uploads/user_profile";
                $originalFileName = pathinfo(
                    $profileImageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $newFileName =
                    "user-" .
                    uniqid() .
                    "-" .
                    Urlizer::urlize($originalFileName) .
                    "." .
                    $profileImageFile->guessExtension();

                $profileImageFile->move($destination, $newFileName);

                $user->setProfile($newFileName);
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash("success", "Mise à jour réussie avec succès!");
        }

        return $this->render(
            $themeResolver->getThemePathPrefix("/core/informations/contents/account.html.twig"),
            [
                "profileCompletionForm" => $form->createView(),
            ]
        );
    }

    #[Route("/informations/settings", name: "app_settings")]
    public function changePassword(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        ThemeResolver $themeResolver
    ): Response {
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->getUser();

            $currentPassword = $form->get("currentPassword")->getData();
            $newPassword = $form->get("newPassword")->getData();
            if (!$userPasswordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash("error", 'L\'ancien mot de passe renseigné est incorrect');
                return $this->redirectToRoute("app_settings");
            }

            $user->setPassword($userPasswordHasher->hashPassword($user, $newPassword));

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash("success", "Votre mot de passe a été modifié avec succès");
        }

        return $this->render(
            $themeResolver->getThemePathPrefix("/core/informations/contents/settings.html.twig"),
            [
                "changePasswordForm" => $form->createView(),
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
