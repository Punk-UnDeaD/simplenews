<?php

declare(strict_types=1);

namespace App\SimpleNews\UseCase\Delete;

class Command
{
    public function __construct(public int $id)
    {
    }
}

