<?php

declare(strict_types=1);

namespace App\SimpleNews\ReadModel;

use App\SimpleNews\Entity\Story;
use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Contracts\Service\Attribute\Required;

class StoryFetcher
{
    #[Required] public EntityManagerInterface $em;

    public function get(int $id)
    {
        $result = $this->qb()
            ->where('id = :id')
            ->setParameter(':id', $id)
            ->execute();

        if (!$result instanceof Result || !($data = $result->fetchAssociative())) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(Story::class, [$id]);
        }

        return new StoryRow(...$data);
    }

    private function qb(): QueryBuilder
    {
        return $this->em
            ->getConnection()
            ->createQueryBuilder()
            ->from('simple_news_story')
            ->select(
                [
                    'id',
                    'title',
                    'body',
                    'author',
                    'createdAt',
                ]
            );
    }

}
