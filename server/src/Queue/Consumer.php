<?php

namespace Server\Queue;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Server\Repository\ImportJobRepository;
use Server\Services\XlsxImportService;
use Throwable;

class Consumer
{

    public function __construct(
        protected XlsxImportService $xlsx,
        private ImportJobRepository $jobRepository
    ) {}

    public function run()
    {

        $logger = new Logger('import');

        $logger->pushHandler(
            new StreamHandler(
                dirname(__DIR__, 2) . '/logs/import.log',
                Logger::ERROR
            )
        );

        $connection = new AMQPStreamConnection(
            'rabbitmq',
            5672,
            'app',
            'app123'
        );

        $channel = $connection->channel();

        $channel->queue_declare('import_jobs', false, true, false, true);

        $channel->basic_consume(
            'import_jobs',
            '',
            false,
            false,
            false,
            false,
            function ($message) use ($logger) {
                try {
                    $data = json_decode(
                        $message->getBody(),
                        true,
                        512
                    );


                    $jobId = $data['jobId'];
                    $filePath = $data['filePath'];

                    $job = $this->jobRepository->findById($jobId);

                    if ($job === null) {
                        throw new \RuntimeException("ImportJob {$jobId} not found");
                    }

                    $job->setStatus('processing');
                    $this->jobRepository->save($job);

                    $this->xlsx->import($filePath, $job);

                    $job->finish();
                    $this->jobRepository->save($job);

                    $message->ack();
                } catch (Throwable $e) {
                    $logger->error('Ошибка импорта XLSX', [
                        'error' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                    ]);
                    $message->nack(false, false);
                }
            }
        );

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }
}
