<?php

declare(strict_types=1);

namespace App\SimpleNews\ReadModel;

class StoryFilter
{
    public ?int $offset;

    public ?int $limit;

    public function __construct(
        public ?array $ids = null,
        public ?string $after = null,
        public ?string $before = null,
        public ?string $orderBy = 'createdAt',
        ?string $offset = '0',
        ?string $limit = '10',
    ) {
        $this->offset = (int)$offset;
        $this->limit = (int)$limit;
    }
}
