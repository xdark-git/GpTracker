<?php

namespace Viewpoint\ThemeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Viewpoint\ThemeBundle\Form\RoomFormType;
use Viewpoint\ThemeBundle\Service\ThemeResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Viewpoint\ThemeBundle\Entity\Room;

class RoomController extends AbstractController
{
    private ThemeResolver $themeResolver;

    public function __construct(ThemeResolver $themeResolver)
    {
        $this->themeResolver = $themeResolver;
    }

    #[Route("/rooms", name: "app_rooms", methods: ["GET"])]
    public function index(): Response
    {
        return $this->render($this->themeResolver->getThemePathPrefix("/core/rooms.html.twig"));
    }

    #[Route("/rooms/new", name: "app_room_creation", methods: ["GET", "POST", "PUT"])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RoomFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $room = $form->getData();

            $roomCellular = $room->getCellular();
            $roomCellular->setRoom($room);
            
            $entityManager->persist($room);
            $entityManager->flush();

            $slug = $room->getSlug();

            $this->addFlash('success', 'Votre annonce a été très bien publié');

            return $this->redirectToRoute('app_room_detail', ['slug' => $slug]);
        }

        return $this->render(
            $this->themeResolver->getThemePathPrefix("/core/room-creation.html.twig"),
            [
                "roomCreationForm" => $form->createView(),
            ]
        );
    }

    #[Route("/rooms/s/{slug}", name: "app_room_detail", methods: ["GET"])]
    public function show(string $slug, EntityManagerInterface $entityManager)
    {
        $room = $entityManager->getRepository(Room::class)->findOneBy(["slug" => $slug]);

        if (!$room) {
            throw $this->createNotFoundException("Page Introuvable");
        }

        return $this->render(
            $this->themeResolver->getThemePathPrefix("/core/room-detail.html.twig"),
            ["room" => $room]
        );
    }
}
