<?php

namespace Server\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Server\Entity\ImportJob;

class ImportJobRepository
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function save(ImportJob $job): void
    {
        $this->em->persist($job);
        $this->em->flush();
    }

    public function findById(string $id): ?ImportJob
    {
        return $this->em->find(ImportJob::class, $id);
    }

    public function getStatus(string $id): ?ImportJob {
        return $this->em->find(ImportJob::class,$id);
    }
}