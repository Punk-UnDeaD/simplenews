<?php

declare(strict_types=1);

namespace App\SimpleNews\ReadModel;

use App\SimpleNews\Entity\Story;
use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Contracts\Service\Attribute\Required;

class StoryFetcher
{
    #[Required] public EntityManagerInterface $em;

    public function get(int $id): StoryRow
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

    /**
     * @param \App\SimpleNews\ReadModel\StoryFilter $filter
     *
     * @return StoryRow[]
     */
    public function find(StoryFilter $filter): array
    {
        $query = $this->qb();
        if (null !== $filter->ids) {
            $query->andWhere('id in (:ids)');
            $query->setParameter(':ids', $filter->ids, \Doctrine\DBAL\Connection::PARAM_INT_ARRAY);
        }

        if (null !== $filter->after) {
            $query->andWhere('createdAt > :after');
            $query->setParameter(':after', $filter->after);
        }

        if (null !== $filter->before) {
            $query->andWhere('createdAt < :before');
            $query->setParameter(':before', $filter->before);
        }
        if (null !== $filter->orderBy) {
            $query->orderBy($filter->orderBy);
        }

        if (null !== $filter->offset) {
            $query->setFirstResult($filter->offset);
        }
        if (null !== $filter->limit) {
            $query->setMaxResults($filter->limit);
        }

        $result = $query->execute();
        $data = $result->fetchAllAssociative();

        return array_map(fn($row) => new StoryRow(...$row), $data);
    }

    public function count(CountStoryFilter $filter): array
    {
        $query = $this->qb();
        $query->select(['count(1) as count', 'Date(createdAt) as date']);
        if (null !== $filter->after) {
            $query->andWhere('createdAt > :after');
            $query->setParameter(':after', $filter->after);
        }

        if (null !== $filter->before) {
            $query->andWhere('createdAt < :before');
            $query->setParameter(':before', $filter->before);
        }
        $query->groupBy('Date(createdAt)');

        return array_map(fn($row) => new CountStoryRow(...$row), $query->execute()->fetchAllAssociative());

    }

}
