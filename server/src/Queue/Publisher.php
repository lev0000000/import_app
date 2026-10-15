<?php

namespace Server\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
class Publisher {

    public function publish($filePatch):void {
        $connection = new AMQPStreamConnection(
            'rabbitmq',
            5672,
            'app',
            'app123'
        );

        try{
            $channel = $connection->channel();

            $channel->queue_declare('import_jobs', false, true,  false, true, false);

            $message = new AMQPMessage(
                json_encode([
                    'file_path' => $filePatch
                ])
            );

            $channel->basic_publish(
                $message,
                '',
                'import_jobs'
            );
            
        }
        finally{
            $connection->close();
        }
    }
}