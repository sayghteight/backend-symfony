<?php

namespace App\Controller;

use App\Entity\RSSSources;
use App\Repository\RSSSourcesRepository;
use Doctrine\ORM\EntityManagerInterface;
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
                'id' => $rssSource->getId(),
                'name' => $rssSource->getName(),
                'url' => $rssSource->getUrl(),
                'enabled' => $rssSource->getEnabled(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/find/{id}', name: 'app_api_find', methods: ['GET'])]
    public function find(RSSSourcesRepository $rssSourcesRepository, int $id): JsonResponse
    {
        $rssSource = $rssSourcesRepository->findBy(['id' => $id]);

        $data[] = [
            'id' => $rssSource[0]->getId(),
            'name' => $rssSource[0]->getName(),
            'url' => $rssSource[0]->getUrl(),
            'enabled' => $rssSource[0]->getEnabled(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/create', name: 'app_api_create_rss', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $rssSource = new RSSSources();
        $rssSource->setName($data['name']);
        $rssSource->setUrl($data['url']);
        $rssSource->setEnabled($data['enabled']);

        $entityManager->persist($rssSource);
        $entityManager->flush();

        return new JsonResponse(['message' => 'RSS source created'], Response::HTTP_CREATED);
    }

    #[Route('/api/update/{id}', name: 'app_api_update_rss', methods: ['PUT'])]
    public function update(Request $request, EntityManagerInterface $entityManager, RSSSources $rssSource): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $rssSource->setName($data['name']);
        $rssSource->setUrl($data['url']);
        $rssSource->setEnabled($data['enabled']);

        $entityManager->flush();

        return new JsonResponse(['message' => 'RSS source updated'], Response::HTTP_OK);
    }

    #[Route('/api/delete/{id}', name: 'app_api_delete_rss', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, RSSSources $rssSource): JsonResponse
    {
        $entityManager->remove($rssSource);
        $entityManager->flush();

        return new JsonResponse(['message' => 'RSS source deleted'], Response::HTTP_OK);
    }
}
