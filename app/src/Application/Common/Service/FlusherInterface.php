<?php

namespace App\Application\Common\Service;

interface FlusherInterface
{
    public function flush(): void;

    public function clear(): void;
}
