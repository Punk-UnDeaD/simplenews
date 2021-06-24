<?php

declare(strict_types=1);

namespace App\SimpleNews\ReadModel;

class CountStoryFilter
{
    public function __construct(
        public ?string $after = null,
        public ?string $before = null,
    ) {
    }
}
