<?php

namespace Server\Services;

use Server\Repository\ProductRepository;

class ProductsListService
{
    public function __construct(
        protected ProductRepository $products
    ) {}

    public function getAll(
        int $page = 1,
        int $limit = 20,
        ?string $name = null,
        ?float $minPrice = null,
        ?float $maxPrice = null
    ): array {
        return $this->products->paginate(
            $page,
            $limit,
            $name,
            $minPrice,
            $maxPrice
        );
    }
}