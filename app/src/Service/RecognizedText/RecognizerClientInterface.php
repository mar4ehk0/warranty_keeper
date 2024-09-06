<?php

namespace App\Service\RecognizedText;

use App\Entity\File;
use App\OCR\Exception\CouldNotRecognizeTextException;

interface RecognizerClientInterface
{
    /**
     * @throws CouldNotRecognizeTextException
     */
    public function sendRequest(File $file): string;
}
