<?php

namespace Viewpoint\ThemeBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Viewpoint\ThemeBundle\Service\ThemeResolver;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Viewpoint\ThemeBundle\Entity\Room;
use Viewpoint\ThemeBundle\Repository\RoomRepository;

class HomeController extends AbstractController
{
    public function __construct(
        private ThemeResolver $themeResolver,
        private EntityManagerInterface $entitymanager
    ) {
    }
    #[Route("/", name: "app_home")]
    public function index(): Response
    {
        /** @var RoomRepository */ 
        $roomRepository = $this->entitymanager->getRepository(Room::class);
        $rooms = $roomRepository->findAvailableRoomForHomePage();
        
        return $this->render($this->themeResolver->getThemePathPrefix("/core/home.html.twig"), [
            "rooms" => $rooms,
        ]);
    }
}
