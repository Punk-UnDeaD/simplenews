<?php

declare(strict_types=1);

namespace App\SimpleNews\Controller;

use App\SimpleNews\ReadModel\StoryFetcher;
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
    #[Route(path: '/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, StoryFetcher $fetcher): JsonResponse
    {
        return $this->json($fetcher->get($id));
    }
}
