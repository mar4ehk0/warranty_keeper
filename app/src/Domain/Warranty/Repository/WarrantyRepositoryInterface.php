<?php

namespace App\Domain\Warranty\Repository;

use App\Domain\Warranty\Entity\Warranty;

interface WarrantyRepositoryInterface
{
    public function add(Warranty $warranty): void;
}
