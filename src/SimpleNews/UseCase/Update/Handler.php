<?php

declare(strict_types=1);

namespace App\SimpleNews\UseCase\Update;

use App\SimpleNews\Entity\Story;
use App\SimpleNews\Repository\StoryRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class Handler implements MessageHandlerInterface
{
    #[Required]
    public StoryRepository $repo;

    public function __invoke(Command $command)
    {
        /** @var Story $story */
        $story = $this->repo->get($command->id);
        if ($command->title !== null) {
            $story->setTitle($command->title);
        }
        if ($command->author !== null) {
            $story->setAuthor($command->author);
        }
        if ($command->body !== null) {
            $story->setBody($command->body);
        }
    }
}
