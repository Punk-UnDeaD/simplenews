<?php

declare(strict_types=1);
namespace App\SimpleNews\ReadModel;

class CountStoryRow implements \JsonSerializable
{
    public int $count;
    public function __construct(
        string $count,
        public string $date,
    ) {
        $this->count = (int)$count;
    }

    public function jsonSerialize()
    {
        return (array)$this;
    }
}
