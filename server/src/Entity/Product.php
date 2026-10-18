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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setDiscount(float $discount): void
    {
        $this->discount = $discount;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalCode(): string
    {
        return $this->externalCode;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getDiscount(): string
    {
        return $this->discount;
    }

    public function setExternalCode(string $externalCode): void
    {
        $this->externalCode = $externalCode;
    }
}
