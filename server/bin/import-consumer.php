<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Server\Queue\Consumer;
use Server\Repository\ProductRepository;
use Server\Services\ProductService;
use Server\Services\XlsxImportService;

$entityManager = require dirname(__DIR__) . '/src/Config/Doctrine.php';

$repository = new ProductRepository($entityManager);

$productService = new ProductService($repository);

$xlsxService = new XlsxImportService($productService);

$consumer = new Consumer($xlsxService);
$consumer->run();
