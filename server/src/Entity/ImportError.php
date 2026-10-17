<?php

namespace Server\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'import_errors')]
class ImportError
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: ImportJob::class)]
    #[ORM\JoinColumn(name: 'job_id', referencedColumnName: 'id', nullable: false)]
    private ImportJob $job;

    #[ORM\Column(name: '`row_number`', type: 'integer')]
    private int $row_number;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $external_code;

    #[ORM\Column(name: '`field`', length: 100)]
    private string $field;

    #[ORM\Column(type: 'text')]
    private string $message;

    public function __construct(
        ImportJob $job,
        int $row_number,
        ?string $external_code,
        string $field,
        string $message
    ) {
        $this->job = $job;
        $this->row_number = $row_number;
        $this->external_code = $external_code;
        $this->field = $field;
        $this->message = $message;
    }

    public function getRowNumber(): int
    {
        return $this->row_number;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
