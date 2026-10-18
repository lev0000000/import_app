<?php

namespace Server\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'import_jobs')]
class ImportJob
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36)]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $filename;

    #[ORM\Column(length: 30)]
    private string $status = 'pending';

    #[ORM\Column]
    private int $total_rows = 0;

    #[ORM\Column]
    private int $success_rows = 0;

    #[ORM\Column]
    private int $failed_rows = 0;

    #[ORM\Column]
    private \DateTimeImmutable $created_at;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $finished_at = null;

    public function __construct(string $id, string $filename)
    {
        $this->id = $id;
        $this->filename = $filename;
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setTotalRows(int $total): void
    {
        $this->total_rows = $total;
    }

    public function incrementSuccess(): void
    {
        $this->success_rows++;
    }

    public function incrementFailed(): void
    {
        $this->failed_rows++;
    }

    public function finish(): void
    {
        $this->status = $this->failed_rows > 0
            ? 'completed_with_errors'
            : 'completed';

        $this->finished_at = new \DateTimeImmutable();
    }

    public function fail(): void
    {
        $this->status = 'failed';
        $this->finished_at = new \DateTimeImmutable();
    }

    public function getFailedRows(): int
    {
        return $this->failed_rows;
    }
}
