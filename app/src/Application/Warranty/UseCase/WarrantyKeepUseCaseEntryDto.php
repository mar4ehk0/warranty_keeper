<?php

namespace App\Application\Warranty\UseCase;

use DateTimeImmutable;
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
    #[Assert\NotBlank]
    public ?string $humanDescription;
    #[Assert\NotNull]
    public ?DateTimeImmutable $warrantyUntil;

    public function __construct(
        ?string $name,
        ?string $humanDescription,
        ?UploadedFile $file,
        ?DateTimeImmutable $warrantyUntil,
    ) {
        $this->name = $name;
        $this->file = $file;
        $this->humanDescription = $humanDescription;
        $this->warrantyUntil = $warrantyUntil;
    }
}
