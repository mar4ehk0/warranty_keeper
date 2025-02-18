<?php

namespace App\Application\Warranty\Service;

use App\Domain\Warranty\Entity\Receipt;
use DateTimeImmutable;
use RuntimeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Factory\UlidFactory;

class ReceiptUpload
{

    public function __construct(
        private readonly string $fileStorage,
        private UlidFactory $ulidFactory
    ) {
    }

    public function upload(UploadedFile $file): Receipt
    {
        $extension = $file->getClientOriginalExtension();
        $id = $this->ulidFactory->create();
        $newFilePath = $this->createFilePath($id->toString(), $extension);

        if (!move_uploaded_file($file->getPathname(), $newFilePath)) {
            throw new ReceiptUploadException($file, $newFilePath);
        }
        $receipt = new Receipt($id, $newFilePath, new DateTimeImmutable());

        return $receipt;
    }

    private function createFilePath(string $newFileName, string $extension): string
    {
        return sprintf('%s/%s.%s', $this->fileStorage, $newFileName, $extension);
    }
}
