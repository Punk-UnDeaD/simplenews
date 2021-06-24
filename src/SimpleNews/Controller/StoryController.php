<?php

declare(strict_types=1);

namespace App\SimpleNews\Controller;

use App\SimpleNews\ReadModel\StoryFetcher;
use App\SimpleNews\ReadModel\StoryFilter;
use App\SimpleNews\UseCase\Create;
use App\SimpleNews\UseCase\Update;
use App\SimpleNews\UseCase\Delete;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController, Route(
    path: 'api/simple-news/story',
    name: 'api.simple-news.story.',
    format: 'json'
)]
class StoryController extends AbstractController
{
    #[Route(path: '/{id}', name: 'show', requirements: ['id' => "\d+"], methods: ['GET'])]
    public function show(int $id, StoryFetcher $fetcher): JsonResponse
    {
        return $this->json($fetcher->get($id));
    }

    #[Route(path: '', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $this->dispatchMessage(new Create\Command(...$data));

        return $this->json(['success' => true]);
    }

    #[Route(path: '/{id}', name: 'update', requirements: ['id' => "\d+"], methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = ['id' => $id] + $request->toArray();
        $this->dispatchMessage(new Update\Command(...$data));

        return $this->json(['success' => true]);
    }

    #[Route(path: '/{id}', name: 'delete', requirements: ['id' => "\d+"], methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $data = ['id' => $id];
        $this->dispatchMessage(new Delete\Command(...$data));

        return $this->json(['success' => true]);
    }

    #[Route(path: '', name: 'index', methods: ['GET'])]
    public function index(Request $request, StoryFetcher $fetcher): JsonResponse
    {
        foreach (['ids', 'after', 'before', 'orderBy', 'offset', 'limit'] as $key) {
            $filterData[$key] = $request->query->get($key);
        }
        $filterData = array_filter($filterData);
        $filter = new StoryFilter(...$filterData);

        return $this->json($fetcher->find($filter));
    }
}
