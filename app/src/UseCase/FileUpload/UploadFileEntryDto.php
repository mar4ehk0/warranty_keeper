<?php

namespace App\UseCase\FileUpload;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileEntryDto
{
    private function __construct(
        public string $name,
        public string $originalPath,
    ) {
    }

    public static function createFromUploadedFile(UploadedFile $file): self
    {
        return new self(
            $file->getClientOriginalName(),
            $file->getPathname(),
        );
    }
}
