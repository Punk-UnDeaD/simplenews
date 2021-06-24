<?php

declare(strict_types=1);

namespace App\SimpleNews\UseCase\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    public function __construct(
        #[Assert\Length(max: 255)]
        public string $title,
        #[Assert\Length(max: 255)]
        public string $author,
        public string $body,
        public ?string $date = null
    ) {
    }
}
