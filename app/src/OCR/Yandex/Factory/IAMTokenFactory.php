<?php

namespace App\OCR\Yandex\Factory;

use App\OCR\Yandex\Entity\IAMToken;
use DateInterval;
use DateTimeImmutable;
use Symfony\Component\Uid\Factory\UlidFactory;

class IAMTokenFactory
{
    public function __construct(
        private UlidFactory $ulidFactory
    ) {
    }

    public function create(string $value, DateInterval $interval = new DateInterval('PT1H')): IAMToken
    {
        $id = $this->ulidFactory->create();
        $now = new DateTimeImmutable();
        $expired = $now->add($interval);

        return new IAMToken($id, $value, $expired);
    }
}
