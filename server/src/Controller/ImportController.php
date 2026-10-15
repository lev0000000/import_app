<?php

namespace Server\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Server\Services\ImportService;

class ImportController
{
    public function __construct(
        private ImportService $importService,
    ) {}

    public function upload(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {

        $files = $request->getUploadedFiles();

        $file = $files['file'] ?? null;

        if (!$file || $file->getError() !== UPLOAD_ERR_OK) {
            $response->getBody()->write('Ошибка загрузки файла');
            return $response->withStatus(400);
        }

        $this->importService->import($file);


        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
