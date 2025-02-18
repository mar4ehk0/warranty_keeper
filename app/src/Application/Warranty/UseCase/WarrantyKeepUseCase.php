<?php

namespace App\Application\Warranty\UseCase;

use App\Application\Warranty\Service\ReceiptUpload;
use App\Domain\Warranty\Entity\Receipt;
use App\Domain\Warranty\Entity\Warranty;
use App\Domain\Warranty\Repository\ReceiptRepositoryInterface;
use App\Domain\Warranty\Repository\WarrantyRepositoryInterface;
use App\Infrastructure\Doctrine\Flusher;
use DateTimeImmutable;
use Symfony\Component\Uid\Factory\UlidFactory;

class WarrantyKeepUseCase
{

    public function __construct(
        private Flusher $flusher,
        private UlidFactory $ulidFactory,
        private ReceiptUpload $receiptUpload,
        private ReceiptRepositoryInterface $receiptRepository,
        private WarrantyRepositoryInterface $warrantyRepository,
    ) {
    }

    public function run(WarrantyKeepUseCaseEntryDto $dto)
    {
        $receipt = $this->receiptUpload->upload($dto->file);
        $warranty = $this->createWarranty($dto, $receipt);
        $this->receiptRepository->add($receipt);
        $this->warrantyRepository->add($warranty);

        $this->flusher->flush();
    }

    private function createWarranty(WarrantyKeepUseCaseEntryDto $dto, Receipt $receipt): Warranty
    {
        $warranty = new Warranty(
            $this->ulidFactory->create(),
            $dto->humanDescription,
            $dto->name,
            $receipt,
            $dto->warrantyUntil,
            new DateTimeImmutable()
        );

        return $warranty;
    }
}
