<?php

declare(strict_types=1);

namespace App\SimpleNews\UseCase\Create;

use App\SimpleNews\Entity\Story;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class Handler implements MessageHandlerInterface
{
    #[Required]
    public EntityManagerInterface $em;

    public function __invoke(Command $command)
    {
        $story = new Story(
            $command->title, $command->author, $command->body,
            $command->date ? new \DateTimeImmutable($command->date) : null
        );
        $this->em->persist($story);
    }
}
