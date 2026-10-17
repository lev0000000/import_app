<?php

namespace Server\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Server\Entity\Product;
use Server\Entity\ProductAttribute;
use Server\Entity\ProductImage;


final class ProductRepository
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    public function findByExternalCode(string $externalCode): ?Product
    {
        return $this->em->getRepository(Product::class)->findOneBy([
            'externalCode' => $externalCode
        ]);
    }

    public function save(Product $product): void
    {
        $this->em->persist($product);
    }

    public function saveAttribute(ProductAttribute $attribute): void
    {
        $this->em->persist($attribute);
    }

    public function findAttributes(Product $product): array
    {
        return $this->em->getRepository(ProductAttribute::class)
            ->findBy(['product' => $product]);
    }

    public function removeAttribute(ProductAttribute $attribute): void
    {
        $this->em->remove($attribute);
    }

    public function saveImage(ProductImage $image): void
    {
        $this->em->persist($image);
    }

    public function findImages(Product $product): array
    {
        return $this->em->getRepository(ProductImage::class)
            ->findBy(['product' => $product]);
    }

    public function removeImage(ProductImage $image): void
    {
        $this->em->remove($image);
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}
