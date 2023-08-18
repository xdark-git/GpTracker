<?php

namespace Viewpoint\ThemeBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Viewpoint\ThemeBundle\Service\ThemeResolver;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Viewpoint\ThemeBundle\Entity\City;
use Viewpoint\ThemeBundle\Entity\Room;
use Viewpoint\ThemeBundle\Form\ContactFormType;
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

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request): Response
    {
        $contactForm = $this->createForm(ContactFormType::class);
        $contactForm->handleRequest($request);

        if($contactForm->isSubmitted() && $contactForm->isValid()){
            dd($contactForm->getData());
        }

        return $this->render($this->themeResolver->getThemePathPrefix('/core/contact.html.twig'), [
            "contactForm" => $contactForm
        ]);
    }    

    #[Route("/code-of-conduct", name: "app_Code_of_Conduct")]
    public function CodeOfConduct(): Response
    {
        return $this->render($this->themeResolver->getThemePathPrefix("/core/CodeOfConduct.html.twig"));
    }

    #[Route("/security-measures", name: "app_Security_measures")]
    public function securityMeasures(): Response
    {
        return $this->render(
            $this->themeResolver->getThemePathPrefix("/core/securityMeasures.html.twig")
        );
    }
}
