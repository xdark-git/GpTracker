<?php

namespace Viewpoint\ThemeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Viewpoint\AdminBundle\Form\ProfileCompletionType;
use Viewpoint\ThemeBundle\Service\ThemeResolver;

class UserController extends AbstractController
{
    #[Route("/informations", name: "app_informations")]
    #[Route("/informations/account", name: "app_informations_user")]
    public function completeProfile(Request $request, ThemeResolver $themeResolver): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileCompletionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profileImageFile = $form->get("profile")->getData();
            if ($profileImageFile) {
                // Handle profile image upload and set user's profile image field
            }
            dd($form-getData());

            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($user);
            // $entityManager->flush();

            // $this->addFlash("success", "Profile completed successfully!");
            // return $this->redirectToRoute("app_home");
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
