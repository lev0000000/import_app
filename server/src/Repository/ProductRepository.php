<?php

namespace Server\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Server\Entity\Product;


final class ProductRepository
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    public function save(Product $product): void
    {
        $this->em->persist($product);
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}