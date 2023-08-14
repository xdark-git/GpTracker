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
use Viewpoint\ThemeBundle\Entity\Room;
use Viewpoint\ThemeBundle\Repository\RoomRepository;

#[Route("/rooms")]
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
        $availableRoomsQuery = $repository->findAvailableRoomsQuery();
        $rooms = $paginator->paginate($availableRoomsQuery, $request->query->getInt("page", 1), 12);
        
        return $this->render($this->themeResolver->getThemePathPrefix("/core/rooms.html.twig"), [
            "rooms" => $rooms,
        ]);
    }

    #[Route("/rooms/new", name: "app_room_creation", methods: ["GET", "POST", "PUT"])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User */
        $user = $this->getUser();
        if (!$user->isAccountCompleted()) {
            $this->addFlash("error", 'Veillez d\'abord compléter votre profile!');
            return $this->redirectToRoute("app_informations_user");
        }

        $form = $this->createForm(RoomFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    #[Route("/CodeOfConduct", name: "app_Code_of_Conduct")]
    public function CodeOfConduct(ThemeResolver $themeResolver): Response
    {
        return $this->render($themeResolver->getThemePathPrefix("/core/CodeOfConduct.html.twig"));
    }
    #[Route("/securityMeasures", name: "app_Security_measures")]
    public function securityMeasures(ThemeResolver $themeResolver): Response
    {
        return $this->render(
            $themeResolver->getThemePathPrefix("/core/securityMeasures.html.twig")
        );
    }
}
