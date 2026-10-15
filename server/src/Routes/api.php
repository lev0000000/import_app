<?php

use Server\Controller\ImportController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app): void {

    $app->group('/api', function (RouteCollectorProxy $group) {

        $group->post('/import', [ImportController::class, 'upload']);

        $group->get('/products', [ProductController::class, 'index']);

        $group->get('/products/{id}', [ProductController::class, 'show']);

    });

};