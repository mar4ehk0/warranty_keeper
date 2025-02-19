<?php

namespace App\Application\OCR;

use App\Domain\Warranty\Entity\Receipt;

interface RecognizerInterface
{
    public function recognize(Receipt $receipt): string;
}
