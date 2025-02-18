<?php

namespace App\Domain\Warranty\Repository;

use App\Domain\Warranty\Entity\Receipt;

interface ReceiptRepositoryInterface
{
    public function add(Receipt $receipt): void;
}
