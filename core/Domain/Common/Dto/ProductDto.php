<?php

namespace NohYooHan\Domain\Common\Dto;

use NohYooHan\Domain\Product\Category;

class ProductDto
{
    private $name;
    private $description;
    private $price;
    private $stock;
    private $category;


    public function __construct(
        string $name = null,
        string $description = null,
        int $price = null,
        int $stock = null,
        Category $category = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->category = $category;
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

    public function getCategory(): Category
    {
        return $this->category;
    }
}