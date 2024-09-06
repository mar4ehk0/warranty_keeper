<?php

namespace App\UseCase\FileUpload;

use App\Doctrine\Flusher;
use App\Service\File\Upload\FileUploaderService;
use App\Service\File\Upload\FileUploaderServiceEntryDto;
use Psr\EventDispatcher\EventDispatcherInterface;

class FileUploaderHandler
{
    public function __construct(
        private FileUploaderService $fileUploaderService,
        private Flusher $flusher,
        private EventDispatcherInterface $dispatcher
    ) {
    }

    public function handle(UploadFileEntryDto $dto): void
    {
        $fileUploaderServiceEntryDto = FileUploaderServiceEntryDto::createFromUploadFileEntryDto($dto);

        $file = $this->fileUploaderService->upload($fileUploaderServiceEntryDto);

        $this->flusher->flush();
        $this->dispatcher->dispatch(new FileUploadedEvent($file->getId()));
    }
}
