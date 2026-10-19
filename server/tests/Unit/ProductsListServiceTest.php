<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Server\Repository\ProductRepository;
use Server\Services\ProductsListService;

final class ProductsListServiceTest extends TestCase
{
    public function testGetByIdReturnsProduct(): void
    {
        $product = [
            'id' => 53,
            'name' => 'Шкаф',
            'price' => 15000.0,
            'images' => [],
            'attributes' => [],
        ];

        $repository = $this->createMock(ProductRepository::class);

        $repository
            ->expects($this->once())
            ->method('findDetailedById')
            ->with(53)
            ->willReturn($product);

        $service = new ProductsListService($repository);

        $result = $service->getById(53);

        $this->assertSame($product, $result);
    }

    public function testGetByIdReturnsNullWhenProductNotFound(): void
    {
        $repository = $this->createMock(ProductRepository::class);

        $repository
            ->expects($this->once())
            ->method('findDetailedById')
            ->with(999)
            ->willReturn(null);

        $service = new ProductsListService($repository);

        $this->assertNull($service->getById(999));
    }
}