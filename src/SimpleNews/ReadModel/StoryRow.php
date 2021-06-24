<?php

declare(strict_types=1);
namespace App\SimpleNews\ReadModel;

class StoryRow implements \JsonSerializable
{
    public int $id;
    public function __construct(
        string $id,
        public string $title,
        public string $author,
        public string $body,
        public string $createdAt,
    ) {
        $this->id = (int)$id;
    }

    public function jsonSerialize()
    {
        return (array)$this;
    }
}
