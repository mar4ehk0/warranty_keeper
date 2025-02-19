<?php

namespace App\Domain\Warranty\Entity;

use App\Domain\BaseEntity;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UlidType;

#[Entity()]
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
    private string $humanDescription;
    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $warrantyUntil;
    #[OneToOne(targetEntity: Receipt::class)]
    #[JoinColumn(name: 'receipt_id', referencedColumnName: 'id')]
    private Receipt $receipt;
    #[ORM\Column(type: 'text')]
    private string $recognisedDescription = '';

    public function __construct(
        string $id,
        string $name,
        string $humanDescription,
        Receipt $receipt,
        DateTimeImmutable $warrantyUntil,
        DateTimeImmutable $createdAt,
    ) {
        parent::__construct($createdAt);
        $this->id = $id;
        $this->name = $name;
        $this->humanDescription = $humanDescription;
        $this->warrantyUntil = $warrantyUntil;
        $this->receipt = $receipt;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
