<?php

namespace App\Repository;

use App\Entity\RecognizedText;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RecognizedTextRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecognizedText::class);
    }

    public function add(RecognizedText $recognizedText): void
    {
        $this->getEntityManager()->persist($recognizedText);
    }
}
