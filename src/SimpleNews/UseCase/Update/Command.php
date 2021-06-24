<?php

declare(strict_types=1);

namespace App\SimpleNews\UseCase\Update;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    public function __construct(
        public int $id,
        #[Assert\Length(max: 255)]
        public ?string $title,
        #[Assert\Length(max: 255)]
        public ?string $author,
        public ?string $body
    ) {
    }
}
