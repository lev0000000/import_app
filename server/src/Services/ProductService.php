<?php

namespace Server\Services;

use Server\Entity\Product;
use Server\Entity\ProductAttribute;
use Server\Entity\ProductImage;
use Server\Repository\ProductRepository;
use Uri\Rfc3986\Uri;

class ProductService
{
    public function __construct(
        private ProductRepository $repository
    ) {}

    public function save(array $result): void
    {

        array_map(function ($item) use ($result) {
            $product = new Product(
                externalCode: $item->externalCode,
                name: $item->name,
                description: $item->description,
                price: $item->price,
                discount: $item->getDiscount(),
            );

            $this->repository->save($product);

            array_map(
                function ($attr, $key) use ($product) {

                    $attribute = new ProductAttribute(
                        product: $product,
                        key: $key,
                        value: (string) $attr,
                    );

                    $this->repository->saveAttribute($attribute);
                },
                array_values($item->attributes),
                array_keys($item->attributes)
            );

            array_map(function ($item) use ($product) {
                $productImage = new ProductImage(
                    product: $product,
                    url: $item['url'],
                    path: $item['path'],
                );

                $this->repository->saveImage($productImage);
            }, $item->images);
        }, $result);


        $this->repository->flush();
    }
}
