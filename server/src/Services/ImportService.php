<?php

namespace Server\Services;

use Psr\Http\Message\UploadedFileInterface;
use Ramsey\Uuid\Uuid;
use Server\Entity\ImportJob;
use Server\Helpers\Log;
use Server\Queue\Publisher;
use Server\Repository\ImportJobRepository;


class ImportService
{

    public function __construct(
        protected Publisher $publisher,
        private ImportJobRepository $jobRepository
    ) {}

    public function import(UploadedFileInterface $file)
    {

        $stream = $file->getStream();
        $filePath = ROOT . '/uploads/import.xlsx';

        $jobId = Uuid::uuid4()->toString();

        $file->moveTo($filePath);
        Log::debug('Warn' . $jobId);

        $job = new ImportJob(
            id: $jobId,
            filename: $file->getClientFilename() ?? 'import.xlsx'
        );

        $this->jobRepository->save($job);

        $this->publisher->publish([
            'filePath' => $filePath,
            'jobId' => $jobId,
        ]);

        return [
            'jobId' => $jobId,
            'filePath' => $filePath,
            'status' => 'pending'
        ];
    }
}
