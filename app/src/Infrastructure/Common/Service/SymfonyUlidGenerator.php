<?php

namespace App\Infrastructure\Common\Service;

use App\Application\Common\Service\GeneratorIdInterface;
use Symfony\Component\Uid\Ulid;

class SymfonyUlidGenerator implements GeneratorIdInterface
{
    public function next(): string
    {
        return Ulid::generate();
    }
}
