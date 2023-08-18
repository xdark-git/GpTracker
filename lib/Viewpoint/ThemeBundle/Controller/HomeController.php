<?php

namespace Viewpoint\ThemeBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Viewpoint\ThemeBundle\Service\ThemeResolver;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Viewpoint\ThemeBundle\Entity\City;
use Viewpoint\ThemeBundle\Entity\Room;
use Viewpoint\ThemeBundle\Form\SearchFormType;
use Viewpoint\ThemeBundle\Repository\RoomRepository;

class HomeController extends AbstractController
{
    public function __construct(
        private ThemeResolver $themeResolver,
        private EntityManagerInterface $entityManager
    ) {
    }
    #[Route("/", name: "app_home")]
    public function index(): Response
    {
        /** @var RoomRepository */ 
        $roomRepository = $this->entityManager->getRepository(Room::class);
        $rooms = $roomRepository->findAvailableRoomForHomePage();

        $searchForm = $this->createForm(type: SearchFormType::class, options: [
            'action' => $this->generateUrl('app_rooms')
        ]);
        $cities = $this->entityManager->getRepository(City::class)->findAll();
        return $this->render($this->themeResolver->getThemePathPrefix("/core/home.html.twig"), [
            "rooms" => $rooms,
            "searchForm" => $searchForm,
            "cities" => $cities
        ]);
    }
}
