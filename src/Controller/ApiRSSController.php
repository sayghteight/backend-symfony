<?php

namespace App\Controller;

use App\Repository\RSSSourcesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiRSSController extends AbstractController
{
    #[Route('/api/getRSS', name: 'app_api_getrss', methods: ['GET'])]
    public function index(RSSSourcesRepository $rssSourcesRepository): JsonResponse
    {
        $rssSources = $rssSourcesRepository->findAll();
        $data = [];

        foreach ($rssSources as $rssSource) {
            $data[] = [
                'name' => $rssSource->getName(),
                'url' => $rssSource->getUrl(),
                'enabled' => $rssSource->getEnabled(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

}
