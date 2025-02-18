<?php

namespace App\Application\UseCase\Warranty;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class WarrantyKeepUseCaseEntryDto
{
    #[Assert\NotBlank]
    public ?string $name;
    #[Assert\NotBlank]
    #[Assert\File(
        maxSize: '10M',
        extensions: ['jpg', 'jpeg', 'png'],
    )]
    public ?UploadedFile $file;

    public function __construct(
        ?string $name,
        ?UploadedFile $file
    ) {
        $this->name = $name;
        $this->file = $file;
    }
}
