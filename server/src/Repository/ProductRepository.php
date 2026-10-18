<?php

namespace Server\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Server\Entity\Product;
use Server\Entity\ProductAttribute;
use Server\Entity\ProductImage;
use Doctrine\ORM\Tools\Pagination\OffsetPaginator;
use Doctrine\ORM\Tools\Pagination\Window;

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

    public function paginate(
        int $page = 1,
        int $limit = 20,
        ?string $name = null,
        ?float $minPrice = null,
        ?float $maxPrice = null
    ): array {
        $page = max(1, $page);
        $limit = min(100, max(1, $limit));

        $qb = $this->em->createQueryBuilder()
            ->select('p')
            ->from(Product::class, 'p');

        if ($name !== null && $name !== '') {
            $qb->andWhere('p.name LIKE :name')
                ->setParameter('name', "%$name%");
        }

        if ($minPrice !== null) {
            $qb->andWhere('p.price >= :min')
                ->setParameter('min', $minPrice);
        }

        if ($maxPrice !== null) {
            $qb->andWhere('p.price <= :max')
                ->setParameter('max', $maxPrice);
        }

        $qb->orderBy('p.id', 'ASC');

        $result = (new OffsetPaginator())->paginate(
            $qb->getQuery(),
            Window::fromPageNumberAndSize($page, $limit)
        );

        $items = array_map(fn(Product $product) => [
            'id' => $product->getId(),
            'external_code' => $product->getExternalCode(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'discount' => $product->getDiscount(),
            'images' => array_map(fn(ProductImage $image) => [
                'id' => $image->getId(),
                'url' => $image->getUrl(),
                'path' => $image->getPath(),
            ], $this->findImages($product)),
        ], $result->getItems());

        return [
            'items' => $items,
            'total' => $result->getTotalCount(),
            'page' => $page,
            'limit' => $limit,
            'totalPages' => (int) ceil($result->getTotalCount() / $limit),
        ];
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}
