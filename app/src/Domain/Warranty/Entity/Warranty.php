<?php

namespace App\Domain\Warranty\Entity;

use App\Domain\BaseEntity;
use App\Domain\Warranty\Repository\WarrantyRepositoryInterface;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;

#[Entity(repositoryClass: WarrantyRepositoryInterface::class)]
#[Table(name: 'Warranty')]
class Warranty extends BaseEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private string $id;
    #[ORM\Column(type: 'string')]
    private string $name;
    #[ORM\Column(type: 'text')]
    private string $description;
    #[ORM\Column(type: 'datetime_immutable')]
    private string $warrantyUntil;

    #[OneToOne(targetEntity: Receipt::class)]
    #[JoinColumn(name: 'receipt_id', referencedColumnName: 'id')]
    private Receipt $receipt;

    public function __construct(
        Ulid $id,
        string $name,
        string $description,
        Receipt $receipt,
        DateTimeImmutable $warrantyUntil,
        DateTimeImmutable $createdAt,
    )
    {
        parent::__construct($createdAt);
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->warrantyUntil = $warrantyUntil;
        $this->receipt = $receipt;
    }
}
