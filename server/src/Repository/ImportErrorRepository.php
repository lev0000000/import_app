<?php

namespace Server\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Server\Entity\ImportError;
use Server\Entity\ImportJob;

class ImportErrorRepository
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function save(ImportError $error): void
    {
        $this->em->persist($error);
        $this->em->flush();
    }

    public function findByJob(ImportJob $job): array
    {
        return $this->em->getRepository(ImportError::class)
            ->findBy(['job' => $job], ['rowNumber' => 'ASC']);
    }
}