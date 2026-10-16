<?php

namespace Server\DTO;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

final readonly class ProductDTO
{
    public function __construct(
        public string $externalCode,
        public string $name,
        public ?string $description,
        public float $price,
        public float $purchasePrice,
        public array $attributes = [],
        public array $images = [],
    ) {}

    public function getDiscount(): float
    {
        return ($this->price - $this->purchasePrice)
            / $this->price * 100;
    }
}
