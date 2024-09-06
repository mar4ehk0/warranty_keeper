<?php

namespace App\Repository;

use App\Entity\File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method File|null find($id, $lockMode = null, $lockVersion = null)
 * @method File|null findOneBy(array $criteria, array $orderBy = null)
 * @method File[]    findAll()
 * @method File[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }

    public function add(File $file): void
    {
        $this->getEntityManager()->persist($file);
    }

    public function getById(string $id): File
    {
        $file = $this->find($id);
        if (!$file instanceof File) {
            throw new EntityNotFoundException();
        }

        return $file;
    }
}
