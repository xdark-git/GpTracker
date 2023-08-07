<?php

namespace Viewpoint\ThemeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Viewpoint\ThemeBundle\Form\RoomFormType;
use Viewpoint\ThemeBundle\Service\ThemeResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class RoomController extends AbstractController
{
    private ThemeResolver $themeResolver;

    public function __construct(ThemeResolver $themeResolver)
    {
        $this->themeResolver = $themeResolver;
    }

    #[Route("/rooms", name: "app_rooms")]
    public function index(): Response
    {
        return $this->render($this->themeResolver->getThemePathPrefix("/core/rooms.html.twig"));
    }

    #[Route("/rooms/create", name: "app_room_creation")]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RoomFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $room = $form->getData();
            $roomCellular = $room->getCellular();
            $roomCellular->setRoom($room);
            // dd($roomCellular);
            $entityManager->persist($room);
            $entityManager->flush();
            dd("new room added");
        }

        return $this->render(
            $this->themeResolver->getThemePathPrefix("/core/room-creation.html.twig"),
            [
                "roomCreationForm" => $form->createView(),
            ]
        );
    }
}
