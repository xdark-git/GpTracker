<?php

namespace Viewpoint\ThemeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Viewpoint\ThemeBundle\Form\RoomFormType;
use Viewpoint\ThemeBundle\Service\ThemeResolver;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Viewpoint\ThemeBundle\Entity\City;
use Viewpoint\ThemeBundle\Entity\Room;
use Viewpoint\ThemeBundle\Entity\RoomViewsHistory;
use Viewpoint\ThemeBundle\Form\RoomSortType;
use Viewpoint\ThemeBundle\Form\SearchFormType;
use Viewpoint\ThemeBundle\Repository\RoomRepository;

#[Route("/annonce")]
class RoomController extends AbstractController
{
    public function __construct(
        private ThemeResolver $themeResolver,
        private EntityManagerInterface $entityManager
    ) {
    }

    #[Route("", name: "app_rooms", methods: ["GET"])]
    public function index(
        Request $request,
        PaginatorInterface $paginator,
        RoomRepository $repository
    ): Response {
        $searchForm = $this->createForm(SearchFormType::class);
        $searchForm->handleRequest($request);
        $searchFormData = $searchForm->getData();

        $sortForm = $this->createForm(RoomSortType::class);
        $sortForm->handleRequest($request);
        $sortFormData = $sortForm->get("sort")->getData();

        $availableRoomsQuery = $repository->findAvailableRoomsQuery($searchFormData, $sortFormData);

        $rooms = $paginator->paginate($availableRoomsQuery, $request->query->getInt("page", 1), 12);

        $cities = $this->entityManager->getRepository(City::class)->findAll();
        return $this->render($this->themeResolver->getThemePathPrefix("/core/rooms.html.twig"), [
            "rooms" => $rooms,
            "cities" => $cities,
            "searchForm" => $searchForm,
            "sortForm" => $sortForm,
        ]);
    }

    #[Route("/creation", name: "app_room_creation", methods: ["GET", "POST", "PUT"])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User */
        $user = $this->getUser();
        if (!$user->isAccountCompleted()) {
            $this->addFlash("error", 'Veillez d\'abord compléter votre profile!');
            return $this->redirectToRoute("app_informations_user");
        }

        $cities = $entityManager->getRepository(City::class)->findAll();

        $form = $this->createForm(RoomFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /*
               all the form not mapped fields are directly handle in formtype 
             */
            $room = $form->getData();

            $roomCellular = $room->getCellular();
            $roomCellular->setRoom($room);

            $entityManager->persist($room);
            $entityManager->flush();

            $slug = $room->getSlug();

            $this->addFlash("success", "Votre annonce a été très bien publié");

            return $this->redirectToRoute("app_room_detail", ["slug" => $slug]);
        }

        return $this->render(
            $this->themeResolver->getThemePathPrefix("/core/room-creation.html.twig"),
            [
                "roomCreationForm" => $form->createView(),
                "cities" => $cities,
            ]
        );
    }

    #[Route("/{slug}", name: "app_room_detail", methods: ["GET"])]
    public function show(string $slug, EntityManagerInterface $entityManager)
    {
        /** @var Room  */
        $room = $entityManager
            ->getRepository(Room::class)
            ->findOneBy(["slug" => $slug, "isDeleted" => false]);

        if (!$room) {
            throw $this->createNotFoundException("Page Introuvable");
        }

        if ($room->getUser() != $this->getUser()) {
            $currentDateTime = new \DateTime();

            /** @var RoomViewsHistory */
            $userLastTimeVisited = $entityManager
                ->getRepository(RoomViewsHistory::class)
                ->findOneBy([
                    "room" => $room,
                    "user" => $this->getUser(),
                ]);

            if (!$userLastTimeVisited) {
                $newViewer = (new RoomViewsHistory())
                    ->setUser($this->getUser())
                    ->setRoom($room)
                    ->setLastTimeVisited($currentDateTime);

                $entityManager->persist($newViewer);
                $entityManager->flush();
            } else {
                $userLastTimeVisited->setLastTimeVisited($currentDateTime);
                $entityManager->flush();
            }
        }
        $viewHistory = $entityManager
            ->getRepository(RoomViewsHistory::class)
            ->findBy(["room" => $room]);
        $viewCount = count($viewHistory);
        $roomName = $room->getName();

        return $this->render(
            $this->themeResolver->getThemePathPrefix("/core/room-detail.html.twig"),
            [
                "room" => $room,
                "viewCount" => $viewCount,
                "roomName" => $roomName,
            ]
        );
    }

    #[Route("/modification/{slug}", name: "app_room_update")]
    public function update(string $slug, Request $request): Response
    {
        /** @var Room */
        $room = $this->entityManager
            ->getRepository(Room::class)
            ->findOneBy(["slug" => $slug, "isDeleted" => false]);

        if (!$room) {
            throw $this->createNotFoundException("Page Introuvable");
        }

        // Check if the current user is the owner of the room
        if ($room->getUser() !== $this->getUser() && !$this->isGranted("ROLE_ADMIN")) {
            throw $this->createAccessDeniedException("You are not authorized to update this room.");
        }

        $form = $this->createForm(RoomFormType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Update the room
            $this->entityManager->flush();

            $newSlug = $room->getSlug();

            $this->addFlash("success", "Votre annonce a été mise à jour avec succès");

            return $this->redirectToRoute("app_room_detail", ["slug" => $newSlug]);
        }

        $cities = $this->entityManager->getRepository(City::class)->findAll();

        return $this->render(
            $this->themeResolver->getThemePathPrefix("/core/room-creation.html.twig"),
            [
                "roomCreationForm" => $form->createView(),
                "cities" => $cities,
            ]
        );
    }

    #[Route("/suppression/{slug}", name: "app_room_delete", methods: ["POST"])]
    public function delete(string $slug, Request $request): Response
    {
        /** @var Room */
        $room = $this->entityManager->getRepository(Room::class)->findOneBy(["slug" => $slug]);

        if (!$room) {
            throw $this->createNotFoundException("Page Introuvable");
        }

        // Check if the current user is the owner of the room or isAdmin
        if ($room->getUser() !== $this->getUser() && !$this->isGranted("ROLE_ADMIN")) {
            throw $this->createAccessDeniedException("Accès non autorisé");
        }

        $submittedToken = $request->request->get("token");

        if ($this->isCsrfTokenValid("delete-room", $submittedToken)) {
            $room->setIsDeleted(true);
            $this->entityManager->flush();

            $this->addFlash("success", "Votre annonce a été supprimée avec succès");

            return $this->redirectToRoute("app_rooms");
        }

        // This code should never be reached, but it's good to include as a fallback
        throw new \Exception("Token introuvable");
    }

}
