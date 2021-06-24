<?php

declare(strict_types=1);

namespace App\SimpleNews\UseCase\Update;

class Command
{
    public function __construct(
        public int $id,
        public ?string $title,
        public ?string $author,
        public ?string $body
    ) {
    }
}
