<?php

namespace App\Infrastructure\Warranty\Service;

use App\Application\Warranty\Service\ReceiptUploaderDTO;
use App\Application\Warranty\Service\ReceiptUploaderException;
use App\Application\Warranty\Service\ReceiptUploaderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Factory\UlidFactory;

class ReceiptFileSystemUploader implements ReceiptUploaderInterface
{
    public function __construct(
        private readonly string $fileStorage,
        private UlidFactory $ulidFactory
    ) {
    }

    /**
     * @throws ReceiptUploaderException
     */
    public function upload(UploadedFile $file): ReceiptUploaderDTO
    {
        $extension = $file->getClientOriginalExtension();
        $id = $this->ulidFactory->create();
        $newFilePath = $this->createFilePath($id->toString(), $extension);

        if (!move_uploaded_file($file->getPathname(), $newFilePath)) {
            throw new ReceiptUploaderException($file->getClientOriginalName(), $newFilePath);
        }

        return new ReceiptUploaderDTO($newFilePath, $id->toString());
    }

    private function createFilePath(string $newFileName, string $extension): string
    {
        return sprintf('%s/%s.%s', $this->fileStorage, $newFileName, $extension);
    }
}
