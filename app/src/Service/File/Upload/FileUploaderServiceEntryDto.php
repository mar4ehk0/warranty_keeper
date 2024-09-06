<?php

namespace App\Service\File\Upload;

use App\UseCase\FileUpload\UploadFileEntryDto;

class FileUploaderServiceEntryDto
{
    private function __construct(
        public string $name,
        public string $path,
    ) {
    }

    public static function createFromUploadFileEntryDto(UploadFileEntryDto $dto): self
    {
        return new self(
            $dto->name,
            $dto->originalPath,
        );
    }
}
