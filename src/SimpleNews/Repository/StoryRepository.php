<?php

declare(strict_types=1);

namespace App\SimpleNews\Repository;

use App\SimpleNews\Entity\Story;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class StoryRepository
 *
 * @extends ServiceEntityRepository<Story>
 */
class StoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Story::class);
    }

    public function get(int $id): Story
    {
        /** @var Story $story */
        if ($story = $this->find($id)) {
            return $story;
        }
        throw EntityNotFoundException::fromClassNameAndIdentifier(Story::class, [$id]);
    }
}
