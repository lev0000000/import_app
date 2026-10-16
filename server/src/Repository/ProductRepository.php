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

    public function save(Product $product): void
    {
        $this->em->persist($product);
    }

    public function saveAttribute(ProductAttribute $attribute): void
    {
        $this->em->persist($attribute);
    }

    public function saveImage(ProductImage $image): void
    {
        $this->em->persist($image);
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}
