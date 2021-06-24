<?php

declare(strict_types=1);

namespace App\SimpleNews\Entity;

use App\SimpleNews\Repository\StoryRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[Orm\Entity(repositoryClass: StoryRepository::class)]
#[Orm\Table(name: 'simple_news_story')]
class Story
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $body;

    #[ORM\Column(type: 'string', length: 255)]
    private string $author;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    public function __construct(string $title, string $body, string $author, ?DateTimeImmutable $createdAt = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
        $this->createdAt = $createdAt ?: new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

}
