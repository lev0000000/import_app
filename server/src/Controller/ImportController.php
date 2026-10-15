<?php

namespace Server\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ImportController
{

    public function upload(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {

        $response->getBody()->write(
            json_encode([
                'success' => true,
                'message' => 'Импорт работает'
            ])
        );

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
