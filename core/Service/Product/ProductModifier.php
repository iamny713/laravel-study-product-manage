<?php

namespace NohYooHan\Service\Product;

use NohYooHan\Domain\Common\Dto\ProductDto;
use NohYooHan\Domain\Product\Product;

class ProductModifier
{
    public function modifyProduct(Product $product, ProductDto $dto)
    {
        $product->name = $dto->getName();
        $product->description = $dto->getDescription() ?: $product->description;
        $product->price = $dto->getPrice();
        $product->stock = $dto->getStock();
    }
}