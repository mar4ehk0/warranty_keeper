<?php

namespace App\Domain\Warranty\Entity;

use App\Domain\BaseEntity;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UlidType;

#[Entity()]
#[Table(name: 'Receipt')]
class Receipt extends BaseEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private string $id;
    #[ORM\Column(type: 'string')]
    private string $name;
    #[ORM\Column(type: 'string')]
    private string $path;

    public function __construct(
        string $id,
        string $name,
        string $path,
        DateTimeImmutable $createdAt,
    ) {
        parent::__construct($createdAt);
        $this->id = $id;
        $this->name = $name;
        $this->path = $path;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
