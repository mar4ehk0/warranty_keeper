<?php

namespace App\Application\Warranty\Service;

use RuntimeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ReceiptUploadException extends RuntimeException
{
    public function __construct(UploadedFile $file, string $newFilePath)
    {
        $message = sprintf(
            'Can not upload file %s to server folder: %s',
            $file->getClientOriginalName(),
            $newFilePath
        );

        parent::__construct($message);
    }
}
