<?php

namespace Server\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'products')]

class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'external_code', type: 'string', length: 255, unique: true)]
    private string $externalCode;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private string $price;

    #[ORM\Column(type: 'decimal', precision: 7, scale: 2)]
    private string $discount;

    public function __construct(
        string $externalCode,
        string $name,
        ?string $description,
        string $price,
        string $discount
    ) {
        $this->externalCode = $externalCode;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->discount = $discount;
    }
}
