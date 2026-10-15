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
        $filePath = ROOT . '/upload/import.xlsx';

        $file->moveTo($filePath);

        $this->publisher->publish($filePath);

        return true;
    }
}
