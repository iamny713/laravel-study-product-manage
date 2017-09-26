<?php

namespace NohYooHan\Service\Product;

use NohYooHan\Domain\Common\Dto\ProductDto;
use NohYooHan\Domain\Product\Product;

class ProductCreator
{
    public function makeProduct(ProductDto $dto)
    {
        /** @var Product $product */
        $product = new Product;
        $product->name = $dto->getName();
        $product->description = $dto->getDescription();
        $product->price = $dto->getPrice();
        $product->stock = $dto->getStock();

        return $product;
    }
}