<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Server\Queue\Consumer;
use Server\Services\XlsxImportService;

$consumer = new Consumer(
    new XlsxImportService()
);

$consumer->run();

