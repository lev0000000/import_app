<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection(
    'rabbitmq',
    5672,
    getenv('RABBITMQ_USER'),
    getenv('RABBITMQ_PASSWORD'),
);

$channel = $connection->channel();

$channel->queue_declare('import_jobs',false,true,false,false);

$channel->basic_consume('import_jobs','',false,false, false,false,function ($message) {
        try {
            $data = json_decode(
                $message->getBody(),
                true,
                512
            );

            

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
