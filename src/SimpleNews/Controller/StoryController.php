<?php

declare(strict_types=1);

use App\SystemNotification\ReadModel\SystemNotificationFetcher;
use App\SystemNotification\ReadModel\SystemNotificationFilter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController, Route(
    path: 'api/simple-news/story',
    name: 'api.simple-news.story.',
    format: 'json'
)]
class StoryController
{
    #[Route(path: '/{id}', name: 'index', methods: ['GET'])]
    public function get(int $id,  $fetcher): JsonResponse
    {
        return $this->json($fetcher->get($id));
    }
}
