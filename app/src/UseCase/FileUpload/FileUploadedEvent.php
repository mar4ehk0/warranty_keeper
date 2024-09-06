<?php

namespace App\UseCase\FileUpload;

class FileUploadedEvent
{
    public function __construct(public readonly string $fileId)
    {
    }
}
