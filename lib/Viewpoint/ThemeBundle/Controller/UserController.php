<?php

namespace Viewpoint\ThemeBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Sluggable\Util\Urlizer;
use Knp\Component\Pager\PaginatorInterface;
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
use Viewpoint\ThemeBundle\Entity\Room;
use Viewpoint\ThemeBundle\Repository\RoomRepository;
#[Route("/informations")]
class UserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ThemeResolver $themeResolver
    ) {
    }
    #[Route("/", name: "app_informations")]
    #[Route("/mon-compte", name: "app_informations_user")]
    public function completeProfile(Request $request): Response
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
            $this->themeResolver->getThemePathPrefix(
                "/core/informations/contents/account.html.twig"
            ),
            [
                "profileCompletionForm" => $form->createView(),
            ]
        );
    }

    #[Route("/parametre", name: "app_settings")]
    public function changePassword(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher
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
            $this->themeResolver->getThemePathPrefix(
                "/core/informations/contents/settings.html.twig"
            ),
            [
                "changePasswordForm" => $form->createView(),
            ]
        );
    }

    #[Route("/mes-annonces", name: "app_user_package")]
    public function emptyPackage(Request $request, PaginatorInterface $paginator): Response
    {
        /** @var RoomRepository */
        $roomRepository = $this->entityManager->getRepository(Room::class);

        $userRoomsQuery = $roomRepository->findCurrentUserRoomQuery($this->getUser());
        $rooms = $paginator->paginate($userRoomsQuery, $request->query->getInt("page", 1), 4);
        
        if ($rooms->getTotalItemCount() == 0) {
            return $this->render(
                $this->themeResolver->getThemePathPrefix(
                    "/core/informations/contents/empty_user_rooms.html.twig"
                )
            );
        }

        return $this->render(
            $this->themeResolver->getThemePathPrefix(
                "/core/informations/contents/user_rooms.html.twig"
            ),
            [
                "rooms" => $rooms,
            ]
        );
    }

    #[Route("/annonces/historique", name: "app_user_room_visited")]
    public function emptyVu(ThemeResolver $themeResolver): Response
    {
        return $this->render(
            $themeResolver->getThemePathPrefix(
                "/core/informations/contents/empty-recently-seen.html.twig"
            )
        );
    }

}
