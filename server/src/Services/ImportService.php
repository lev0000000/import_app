<?php

namespace Server\Services;

use Psr\Http\Message\UploadedFileInterface;
use Server\Queue\Publisher;

class ImportService
{

    public function __construct(
        protected Publisher $publisher
    ) {}

    public function import(UploadedFileInterface $file)
    {

        $stream = $file->getStream();
        $path = $stream->getMetadata('uri');

        $file->moveTo(ROOT . '/upload/import.xlsx');

        $this->publisher->publish($path);

        return true;
    }
}
