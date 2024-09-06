<?php

namespace App\Service\RecognizedText;

use App\Doctrine\Flusher;
use App\Entity\File;
use App\Entity\RecognizedText;
use App\OCR\Exception\CouldNotRecognizeTextException;
use App\Repository\RecognizedTextRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Factory\UlidFactory;

class RecognizedTextService
{
    public function __construct(
        private RecognizerClientInterface $clientRecognizer,
        private Flusher $flusher,
        private UlidFactory $ulidFactory,
        private RecognizedTextRepository $recognizedTextRepository,
        private LoggerInterface $logger
    ) {
    }

    public function recognize(File $file): void
    {
        try {
            $text = $this->clientRecognizer->sendRequest($file);
            $id = $this->ulidFactory->create()->toString();

            // нужно сделать удаление служебных символов внутри расопознованого текста

            $recognizedText = new RecognizedText($id, trim($text), $file);

            $this->recognizedTextRepository->add($recognizedText);

            $this->flusher->flush();
        } catch (CouldNotRecognizeTextException $e) {
            $this->logger->debug('CouldNotRecognizeTextException: ' . $e->getMessage(), ['exception' => $e]);
        }
    }
}
