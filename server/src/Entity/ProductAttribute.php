<?php

namespace Server\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'product_attributes')]
class ProductAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: Product::class)]
        #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', nullable: false)]
        private Product $product,

        #[ORM\Column(name: '`key`', type: 'string', length: 255)]
        private string $key,

        #[ORM\Column(name: '`value`', type: 'text')]
        private string $value,
    ) {}
}