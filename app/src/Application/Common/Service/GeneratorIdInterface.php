<?php

namespace App\Application\Common\Service;

interface GeneratorIdInterface
{
    public function next(): string;
}
