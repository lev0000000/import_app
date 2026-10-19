<?php

namespace Server\Controller;

use Server\Services\ProductsListService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ProductController
{
    public function __construct(
        private ProductsListService $service
    ) {}

    public function index(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $params = $request->getQueryParams();

        $result = $this->service->getAll(
            page: (int) ($params['page'] ?? 1),
            limit: (int) ($params['limit'] ?? 20),
            name: $params['name'] ?? null,
            minPrice: isset($params['minPrice']) ? (float) $params['minPrice'] : null,
            maxPrice: isset($params['maxPrice']) ? (float) $params['maxPrice'] : null
        );

        $response->getBody()->write(json_encode($result, JSON_UNESCAPED_UNICODE));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $id = (int) $args['id'];

        $product = $this->service->getById($id);

        if (!$product) {
            $response->getBody()->write(json_encode([
                'error' => 'Товар не найден'
            ], JSON_UNESCAPED_UNICODE));

            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(
            json_encode($product, JSON_UNESCAPED_UNICODE)
        );

        return $response->withHeader('Content-Type', 'application/json');
    }
}
