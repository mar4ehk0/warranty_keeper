<?php

namespace App\Application\Warranty\UseCase;

use App\Application\Common\Service\FlusherInterface;
use App\Application\Common\Service\GeneratorIdInterface;
use App\Application\Warranty\Service\ReceiptUploaderDTO;
use App\Application\Warranty\Service\ReceiptUploaderException;
use App\Application\Warranty\Service\ReceiptUploaderInterface;
use App\Domain\Warranty\Entity\Receipt;
use App\Domain\Warranty\Entity\Warranty;
use App\Domain\Warranty\Repository\ReceiptRepositoryInterface;
use App\Domain\Warranty\Repository\WarrantyRepositoryInterface;
use DateTimeImmutable;
use Psr\Log\LoggerInterface;
use RuntimeException;

class WarrantyKeepUseCase
{
    public function __construct(
        private FlusherInterface $flusher,
        private GeneratorIdInterface $generatorId,
        private ReceiptUploaderInterface $receiptUpload,
        private ReceiptRepositoryInterface $receiptRepository,
        private WarrantyRepositoryInterface $warrantyRepository,
        private LoggerInterface $logger,
    ) {
    }

    public function run(WarrantyKeepUseCaseEntryDto $dto)
    {
        try {
            $receiptDto = $this->receiptUpload->upload($dto->file);
        } catch (ReceiptUploaderException $exception) {
            $this->logger->error($exception->getMessage());
            throw new RuntimeException($exception->getMessage());
        }
        $receipt = $this->createReceipt($receiptDto);
        $warranty = $this->createWarranty($dto, $receipt);

        $this->receiptRepository->add($receipt);
        $this->warrantyRepository->add($warranty);

        $this->flusher->flush();
    }

    private function createReceipt(ReceiptUploaderDTO $dto): Receipt
    {
        $receipt = new Receipt($this->generatorId->next(), $dto->fileName, $dto->filePath, new DateTimeImmutable());

        return $receipt;
    }

    private function createWarranty(WarrantyKeepUseCaseEntryDto $dto, Receipt $receipt): Warranty
    {
        $warranty = new Warranty(
            $this->generatorId->next(),
            $dto->humanDescription,
            $dto->name,
            $receipt,
            $dto->warrantyUntil,
            new DateTimeImmutable()
        );

        return $warranty;
    }
}
