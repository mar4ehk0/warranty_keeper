<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Warranty\Entity\Warranty;
use App\Domain\Warranty\Repository\WarrantyRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class WarrantyRepository implements WarrantyRepositoryInterface
{
    private EntityRepository $repo;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->repo = $this->entityManager->getRepository(Warranty::class);
    }

    public function add(Warranty $warranty): void
    {
        $this->entityManager->persist($warranty);
    }
}
