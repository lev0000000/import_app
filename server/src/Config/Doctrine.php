<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once dirname(__DIR__,2) . '/vendor/autoload.php';

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [dirname(__DIR__,2) . '/Entity'],
    isDevMode: true,
);
$config->enableNativeLazyObjects(true);

$connection = DriverManager::getConnection([
    'driver' => 'pdo_mysql',
    'host' => getenv('DB_HOST'),
    'port' => (int) getenv('DB_PORT'),
    'dbname' => getenv('DB_NAME'),
    'user' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8mb4',
]);

return new EntityManager($connection, $config);