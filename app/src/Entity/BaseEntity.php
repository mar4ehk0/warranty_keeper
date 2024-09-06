<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

abstract class BaseEntity
{
    #[ORM\Column(type: 'datetime_immutable')]
    protected DateTimeImmutable $createdAt;
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    protected DateTimeImmutable $updatedAt;

    public function __construct(DateTimeImmutable $createdAt = new DateTimeImmutable())
    {
        $this->createdAt = $createdAt;
    }

    public function touch(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
