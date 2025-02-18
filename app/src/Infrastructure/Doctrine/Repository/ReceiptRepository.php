<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Warranty\Entity\Receipt;
use App\Domain\Warranty\Repository\ReceiptRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ReceiptRepository implements ReceiptRepositoryInterface
{
    private EntityRepository $repo;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->repo = $this->entityManager->getRepository(Receipt::class);
    }

    public function add(Receipt $receipt): void
    {
        $this->entityManager->persist($receipt);
    }
}
