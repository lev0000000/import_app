<?php

namespace Server\Services;

use Psr\Http\Message\UploadedFileInterface;
use Server\Entity\ImportJob;
use Server\Queue\Publisher;
use Server\Repository\ImportJobRepository;
use Ramsey\Uuid\Uuid;


class ImportService
{

    public function __construct(
        protected Publisher $publisher,
        private ImportJobRepository $jobRepository
    ) {}

    public function import(UploadedFileInterface $file)
    {

        $stream = $file->getStream();
        $filePath = ROOT . '/upload/import.xlsx';

        $jobId = Uuid::uuid4()->toString();

        $file->moveTo($filePath);

        $this->publisher->publish(json_encode([
            'jobId' => $jobId,
            'filePath' => $filePath
        ]));

        $job = new ImportJob(
            id: $jobId,
            filename: $file->getClientFilename() ?? 'import.xlsx'
        );

        $this->jobRepository->save($job);


        return [
            'jobId' => $jobId,
            'status' => 'pending'
        ];
    }
}
