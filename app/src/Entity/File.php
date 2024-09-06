<?php

namespace App\Entity;

use App\Repository\FileRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: FileRepository::class)]
#[Table(name: 'file')]
class File extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: 'ulid', length: 26)]
    private string $id;
    #[ORM\Column(type: 'string')]
    private string $path;
    #[ORM\Column(type: 'string')]
    private string $name;

    public function __construct(
        string $id,
        string $path,
        string $name
    ) {
        parent::__construct(new DateTimeImmutable());

        $this->id = $id;
        $this->path = $path;
        $this->name = $name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
