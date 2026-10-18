<?php

namespace Server\Services;

use Server\Repository\ImportJobRepository;

class StatusService
{

    public function __construct(
        protected ImportJobRepository $importJobRepository
    ) {}
    public function getStatus($id) {
        $status_entity = $this->importJobRepository->getStatus($id);

        $result = $status_entity->getStatus();

        return $result;
    }
}
