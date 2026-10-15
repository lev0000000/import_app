<?php

namespace Server\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Server\Services\XlsxImportService;
use Throwable;

class Consumer
{

    public function __construct(protected XlsxImportService $xlsx) {}

    public function run()
    {
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
            function ($message) {
                try {
                    $data = json_decode(
                        $message->getBody(),
                        true,
                        512
                    );
                    $this->xlsx->import($data['file_path']);
                    $message->ack();
                } catch (Throwable $e) {
                    echo "Ошибка: {$e->getMessage()}\n";
                    $message->nack(false, false);
                }
            }
        );

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }
}
