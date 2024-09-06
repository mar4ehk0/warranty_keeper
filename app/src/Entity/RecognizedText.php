<?php

namespace App\Entity;

use App\Repository\RecognizedTextRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: RecognizedTextRepository::class)]
#[Table(name: 'recognized_text')]
class RecognizedText extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: 'ulid', length: 26)]
    private string $id;
    #[ORM\Column(type: 'text')]
    private string $text;
    #[OneToOne(targetEntity: File::class)]
    #[JoinColumn(name: 'file_id', referencedColumnName: 'id')]
    private File $file;

    public function __construct(
        string $id,
        string $text,
        File $file
    ) {
        parent::__construct(new DateTimeImmutable());

        $this->id = $id;
        $this->text = $text;
        $this->file = $file;
    }
}
