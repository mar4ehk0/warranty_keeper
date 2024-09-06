<?php

namespace App\EventListener;

use App\Repository\FileRepository;
use App\Service\RecognizedText\RecognizedTextService;
use App\UseCase\FileUpload\FileUploadedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: FileUploadedEvent::class)]
class RecognizeTextListener
{
    public function __construct(
        private RecognizedTextService $service,
        private FileRepository $fileRepository
    ) {
    }

    public function __invoke(FileUploadedEvent $event): void
    {
        // передать в публишер дто для распознания текста.
        $file = $this->fileRepository->getById($event->fileId);
        $this->service->recognize($file);
    }
}
