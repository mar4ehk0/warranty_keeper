<?php

namespace App\Application\Warranty\Service;

use RuntimeException;

class ReceiptUploaderException extends RuntimeException
{
    public function __construct(string $fileName, string $filePath)
    {
        $message = sprintf(
            'Can not upload file %s to : %s',
            $fileName,
            $filePath
        );

        parent::__construct($message);
    }
}
