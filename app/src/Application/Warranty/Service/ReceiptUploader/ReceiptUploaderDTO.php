<?php

namespace App\Application\Warranty\Service\ReceiptUploader;

final readonly class ReceiptUploaderDTO
{
    public function __construct(
        public string $filePath,
        public string $fileName
    ) {
    }
}
