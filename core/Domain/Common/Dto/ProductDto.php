<?php

namespace NohYooHan\Domain\Common\Dto;

class ProductDto
{
    private $name;
    private $description;
    private $price;
    private $stock;

    public function __construct(
        string $name = null,
        string $description = null,
        int $price = null,
        int $stock = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getStock()
    {
        return $this->stock;
    }
}