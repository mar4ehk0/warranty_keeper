<?php

namespace App\Service\File\Upload;

use App\Entity\File;
use App\Repository\FileRepository;
use RuntimeException;
use Symfony\Component\Uid\Factory\UlidFactory;

class FileUploaderService
{
    public function __construct(
        private readonly string $fileStorage,
        private UlidFactory $ulidFactory,
        private FileRepository $files,
    ) {
    }

    public function upload(FileUploaderServiceEntryDto $dto): File
    {
        $extension = $this->getFileExtension($dto->name);
        $fileId = $newFileName = $this->getNewFileId();
        $newFilePath = $this->createFilePath($newFileName, $extension);
        if (!move_uploaded_file($dto->path, $newFilePath)) {
            throw new RuntimeException();
        }
        $file = new File($fileId, $newFilePath, $dto->name);
        $this->files->add($file);

        return $file;
    }

    private function createFilePath(string $newFileName, string $extension): string
    {
        return sprintf('%s/%s.%s', $this->fileStorage, $newFileName, $extension);
    }

    private function getNewFileId(): string
    {
        return $this->ulidFactory->create()->toString();
    }

    private function getFileExtension(string $originalPath): string
    {
        $data = pathinfo($originalPath);

        return $data['extension'];
    }
}
