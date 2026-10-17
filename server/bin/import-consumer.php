<?php

use Server\Repository\ImportErrorRepository;

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Server\Queue\Consumer;
use Server\Repository\ImportJobRepository;
use Server\Repository\ProductRepository;
use Server\Services\ImportErrorService;
use Server\Services\ProductService;
use Server\Services\XlsxImportService;

$entityManager = require dirname(__DIR__) . '/src/Config/Doctrine.php';

$repository = new ProductRepository($entityManager);

$repositoryError = new ImportErrorRepository($entityManager);

$repositoryJob = new ImportJobRepository($entityManager);

$productService = new ProductService($repository,$entityManager);

$errorService = new ImportErrorService($repositoryError);

$xlsxService = new XlsxImportService($productService, $errorService, $repositoryJob);

$consumer = new Consumer($xlsxService, $repositoryJob);
$consumer->run();
