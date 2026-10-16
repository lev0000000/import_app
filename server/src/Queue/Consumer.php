<?php

namespace Server\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Server\Services\XlsxImportService;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Throwable;

class Consumer
{

    public function __construct(protected XlsxImportService $xlsx) {}

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
                    $this->xlsx->import($data['file_path']);
                    $message->ack();
                } catch (Throwable $e) {
                    $logger->error('Ошибка импорта XLSX', [
                        'error' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                    ]);
                }
            }
        );

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }
}
