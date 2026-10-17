<?php

namespace Server\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Publisher
{
    public function publish(array $itemMessage): void
    {
        $connection = new AMQPStreamConnection(
            'rabbitmq',
            5672,
            'app',
            'app123'
        );

        try {
            $channel = $connection->channel();

            $channel->queue_declare(
                'import_jobs',
                false,
                true,
                false,
                true
            );

            $message = new AMQPMessage(
                json_encode($itemMessage)
            );


            $channel->basic_publish(
                $message,
                '',
                'import_jobs'
            );

            $channel->close();
        } finally {
            $connection->close();
        }
    }
}
