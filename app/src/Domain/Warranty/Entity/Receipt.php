<?php

namespace App\Domain\Warranty\Entity;

use App\Domain\BaseEntity;
use App\Domain\Warranty\Repository\ReceiptRepositoryInterface;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Ulid;

#[Entity()]
#[Table(name: 'Receipt')]
class Receipt extends BaseEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private Ulid $id;
    #[ORM\Column(type: 'string')]
    private string $name;
    #[ORM\Column(type: 'string')]
    private string $path;

    public function __construct(
        Ulid $id,
        string $path,
        DateTimeImmutable $createdAt,
    )
    {
        parent::__construct($createdAt);
        $this->id = $id;
        $this->name = $id->toString();
        $this->path = $path;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }
}
