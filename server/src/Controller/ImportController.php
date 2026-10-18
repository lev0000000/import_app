<?php

namespace Server\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Server\Helpers\Log;
use Server\Services\ImportService;
use Server\Services\StatusService;

class ImportController
{
    public function __construct(
        private ImportService $importService,
        private StatusService $statusService
    ) {}

    public function upload(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {

        $file = $request->getUploadedFiles()['file'] ?? null;


        if (!$file || $file->getError() !== UPLOAD_ERR_OK) {
            $response->getBody()->write('Ошибка загрузки файла');
            return $response->withStatus(400);
        }

        $res = $this->importService->import($file);

        $response->getBody()->write(
            json_encode($res)
        );

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function status(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $id = $args['id'];
        $result =  $this->statusService->getStatus($id);

        $response->getBody()->write(json_encode([
            'jobId' => $result
        ]));


        return $response->withHeader('Content-Type', 'application/json');
    }
}
