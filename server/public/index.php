<?php
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Tuupola\Middleware\CorsMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$container = (new ContainerBuilder())->build();

AppFactory::setContainer($container);

$app = AppFactory::create();


(require __DIR__ . '/../src/Routes/api.php')($app);

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->add(new CorsMiddleware([
    'origin' => ['http://localhost:4200'],
    'methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
    'headers.allow' => ['Content-Type', 'Authorization'],
    'credentials' => false,
    'cache' => 3600,
]));

$app->run();