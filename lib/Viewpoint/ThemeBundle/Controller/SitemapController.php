<?php

namespace Viewpoint\ThemeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Viewpoint\ThemeBundle\Repository\RoomRepository;
use Viewpoint\ThemeBundle\Service\ThemeResolver;

class SitemapController extends AbstractController
{
    #[Route("/sitemap.xml", defaults: ["_format" => "xml"])]
    public function index(
        Request $request,
        ThemeResolver $themeResolver,
        RoomRepository $roomRepository
    ): Response {
        $hostname = $request->getSchemeAndHttpHost();
        $urls = [];

        $urls[] = [
            "loc" => $this->generateUrl("app_home"),
            "priority" => "1.0",
            "changefreq" => "daily",
        ];
        $urls[] = [
            "loc" => $this->generateUrl("app_contact"),
            "priority" => "0.8",
        ];
        $urls[] = [
            "loc" => $this->generateUrl("app_about_us"),
            "priority" => "0.8",
        ];
        $urls[] = [
            "loc" => $this->generateUrl("app_terms_conditions"),
            "priority" => "0.8",
            "changefreq" => "monthly",
        ];
        $urls[] = [
            "loc" => $this->generateUrl("app_rooms"),
            "priority" => "0.9",
            "changefreq" => "hourly",
        ];

        $rooms = $roomRepository->findAvailableRoomsQuery()->getResult();

        foreach ($rooms as $room) {
            $urls[] = [
                "loc" => $this->generateUrl("app_room_detail", ["slug" => $room->getSlug()]),
                "lastmod" => $room->getUpdatedAt()->format("Y-m-d"),
                "priority" => "0.8",
                "changefreq" => "daily",
            ];
        }

        $response = new Response(
            $this->renderView($themeResolver->getThemePathPrefix("/sitemap/sitemap.html.twig"), [
                "hostname" => $hostname,
                "urls" => $urls,
            ]),
            200
        );

        $response->headers->set("Content-type", "text/xml");

        return $response;
    }

    #[Route("/ads.txt", defaults: ["_format" => "txt"])]
    public function ads(
        ThemeResolver $themeResolver,
    ): Response {
        

        $response = new Response(
            $this->renderView($themeResolver->getThemePathPrefix("/sitemap/ads.html.twig")),
            200
        );

        $response->headers->set("Content-type", "text/plain");

        return $response;
    }
}
