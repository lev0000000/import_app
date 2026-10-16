<?php

namespace Server\Services;

use Server\Entity\Product;
use Server\Repository\ProductRepository;

class ProductService
{
    public function __construct(
        private ProductRepository $repository
    ) {}

    public function save(array $result): void
    {

        array_map(function($item){
            $product = new Product(
            externalCode: $item->externalCode,
            name:$item->name,
            description:$item->description,
            price: $item->price,
            discount: $item->getDiscount(),);

            $this->repository->save($product);

        }, $result);


        
        $this->repository->flush();
    }
}
