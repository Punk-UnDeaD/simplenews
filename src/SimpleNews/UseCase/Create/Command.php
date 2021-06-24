<?php

declare(strict_types=1);

namespace App\SimpleNews\UseCase\Create;

class Command
{
    public function __construct(
        public string $title,
        public string $author,
        public string $body,
        public ?string $date = null
    ) {
    }
}
