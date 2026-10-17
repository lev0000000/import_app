<?php

namespace Server\Services;

use Server\Entity\ImportJob;
use Server\Entity\ImportError;
use Server\Repository\ImportErrorRepository;

class ImportErrorService
{
    public function __construct(
        private ImportErrorRepository $repository
    ) {}

    public function add(
        ImportJob $job,
        int $row,
        ?string $externalCode,
        string $field,
        string $message
    ): void {
        $error = new ImportError(
            job: $job,
            row_number: $row,
            external_code: $externalCode,
            field: $field,
            message: $message
        );

        $this->repository->save($error);
    }
}