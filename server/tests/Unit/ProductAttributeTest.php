<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Server\Entity\Product;
use Server\Entity\ProductAttribute;

final class ProductAttributeTest extends TestCase
{
    public function testCreateAttribute(): void
    {
        $product = $this->createStub(Product::class);

        $attribute = new ProductAttribute(
            $product,
            'Цвет',
            'Черный'
        );

        $this->assertSame('Цвет', $attribute->getKey());
        $this->assertSame('Черный', $attribute->getValue());
        $this->assertSame($product, $attribute->getProduct());
        $this->assertNull($attribute->getId());
    }

    public function testUpdateAttribute(): void
    {
        $product = $this->createStub(Product::class);

        $attribute = new ProductAttribute(
            $product,
            'Цвет',
            'Белый'
        );

        $attribute->setKey('Материал');
        $attribute->setValue('Сталь');

        $this->assertSame('Материал', $attribute->getKey());
        $this->assertSame('Сталь', $attribute->getValue());
    }
}
