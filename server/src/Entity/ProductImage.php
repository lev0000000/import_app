<?php

namespace Server\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'product_images')]
class ProductImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(name: 'product_id', nullable: false)]

    private Product $product;

    #[ORM\Column(type: 'string', length: 2048)]
    private string $url;

    #[ORM\Column(type: 'string', length: 1024)]
    private string $path;

    public function __construct(
        Product $product,
        string $url,
        string $path
    ) {
        $this->product = $product;
        $this->url = $url;
        $this->path = $path;
    }

    public function getId():int {
        return $this->id;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getUrl():string{
        return $this->url;
    }
}
