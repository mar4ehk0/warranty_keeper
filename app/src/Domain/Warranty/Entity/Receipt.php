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

#[Entity(repositoryClass: ReceiptRepositoryInterface::class)]
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
        Ulid $id,
        string $name,
        string $path,
        DateTimeImmutable $createdAt,
    )
    {
        parent::__construct($createdAt);
        $this->id = $id;
        $this->name = $name;
        $this->path = $path;
        $this->createdAt = $createdAt;
    }
}
