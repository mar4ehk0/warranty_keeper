<?php

namespace App\Application\Warranty\Service\ReceiptUploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ReceiptUploaderInterface
{
    /**
     * @throws ReceiptUploaderException
     */
    public function upload(UploadedFile $file): ReceiptUploaderDTO;
}
