<?php

declare(strict_types=1);

namespace App\SimpleNews\UseCase\Delete;

use App\SimpleNews\Entity\Story;
use App\SimpleNews\Repository\StoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class Handler implements MessageHandlerInterface
{
    #[Required]
    public EntityManagerInterface $em;

    #[Required]
    public StoryRepository $repo;

    public function __invoke(Command $command)
    {
        $story = $this->repo->get($command->id);

        $this->em->remove($story);
    }
}
