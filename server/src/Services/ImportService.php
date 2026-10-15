<?php
namespace Server\Services;

use Psr\Http\Message\UploadedFileInterface;

class ImportService {

    public function import(UploadedFileInterface $file) {

        $stream = $file->getStream();
        $path = $stream->getMetadata('uri');


        error_log('Имя файла: ' . $file->getClientFilename());
        error_log('Размер файла: ' . $file->getSize());
        error_log('Путь: ' . var_export($path, true));
        error_log($stream);

        return true;
    }

}