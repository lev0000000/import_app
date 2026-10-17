<?php

namespace Server\Services;

use Doctrine\ORM\EntityManagerInterface;
use Server\Entity\Product;
use Server\Entity\ProductAttribute;
use Server\Entity\ProductImage;
use Server\Helpers\Log;
use Server\Repository\ProductRepository;
use Throwable;

class ProductService
{
    public function __construct(
        private ProductRepository $repository,
        private EntityManagerInterface $em,
    ) {}

    public function save(array $result): void
    {
        $connection = $this->em->getConnection();
        $connection->beginTransaction();

        try {
            array_map(function ($item) use ($result) {

                $product = $this->repository->findByExternalCode($item->externalCode);

                if ($product === null) {
                    $product = new Product(
                        externalCode: $item->externalCode,
                        name: $item->name,
                        description: $item->description,
                        price: $item->price,
                        discount: $item->getDiscount(),
                    );
                } else {
                    $product->setName($item->name);
                    $product->setDescription($item->description);
                    $product->setPrice($item->price);
                    $product->setDiscount($item->getDiscount());
                }

                $this->repository->save($product);

                $existing = $this->repository->findAttributes($product);

                $old = [];

                foreach ($existing as $attribute) {
                    $old[$attribute->getKey()] = $attribute;
                }

                array_map(
                    function ($attr, $key) use ($product, $old) {

                        if (isset($old[$key])) {
                            if ($old[$key]->getValue() !== (string) $attr) {
                                $old[$key]->setValue((string) $attr);
                            }

                            return;
                        }

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

                array_map(
                    fn($attribute) => $this->repository->removeAttribute($attribute),
                    array_values(array_diff_key($old, $item->attributes))
                );

                $existing = $this->repository->findImages($product);

                $old = [];

                array_map(function ($image) use (&$old) {
                    $old[$image->getUrl()] = $image;
                }, $existing);

                $new = array_column($item->images, null, 'url');

                array_map(function ($image) use ($product, $old) {

                    $url = $image['url'];
                    $path = $image['path'];

                    if (isset($old[$url])) {
                        if ($old[$url]->getPath() !== $path) {
                            $old[$url]->setPath($path);
                        }
                        return;
                    }
                    if (!$url || !$path) {
                        return;
                    }

                    $productImage = new ProductImage(
                        product: $product,
                        url: $url,
                        path: $path
                    );

                    $this->repository->saveImage($productImage);
                }, $item->images);

                array_map(
                    fn($image) => $this->repository->removeImage($image),
                    array_values(array_diff_key($old, $new))
                );
            }, $result);

            $this->repository->flush();
            $connection->commit();
        } catch (Throwable $e) {
            $connection->rollBack();
            Log::error('Ошибка сохранения товаров', [
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
