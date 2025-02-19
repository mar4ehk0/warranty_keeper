<?php

namespace App\Application\OCR\Service\Recognize;

interface RecognizerInterface
{
    public function recognize(string $pathToFile): string;
}
