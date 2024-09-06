<?php

namespace App\OCR\Yandex\Entity;

use App\Entity\BaseEntity;
use App\OCR\Yandex\Repository\IAMTokenRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: IAMTokenRepository::class)]
#[Table(name: 'yandex_iam_token')]
class IAMToken extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: 'ulid', length: 26)]
    private string $id;

    #[ORM\Column(type: 'string', length: 300, unique: true)]
    private string $value;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $expired;

    public function __construct(string $id, string $value, DateTimeImmutable $expired)
    {
        parent::__construct(new DateTimeImmutable());

        $this->id = $id;
        $this->value = $value;
        $this->expired = $expired;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
