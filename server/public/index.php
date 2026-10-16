<?php
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Tuupola\Middleware\CorsMiddleware;
use Doctrine\ORM\EntityManagerInterface;

require __DIR__ . '/../src/Config/Config.php';
require ROOT . '/vendor/autoload.php';


$builder = new ContainerBuilder();

$builder->addDefinitions([
    EntityManagerInterface::class => require ROOT . '/src/Config/Doctrine.php',
]);

$container = $builder->build();

AppFactory::setContainer($container);

$app = AppFactory::create();


(require ROOT . '/src/Routes/api.php')($app);

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