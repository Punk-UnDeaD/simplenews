<?php

declare(strict_types=1);

namespace App\SimpleNews\Controller;

use App\SimpleNews\ReadModel\StoryFetcher;
use App\SimpleNews\UseCase\Create;
use App\SimpleNews\UseCase\Update;
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

} 
