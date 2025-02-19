<?php

namespace App\Infrastructure\OCR\Service;

use App\Application\OCR\Service\Recognize\RecognizerInterface;

class YandexRecognizer implements RecognizerInterface
{
    public function recognize(string $pathToFile): string
    {
        return '';
    }
}
