<?php

namespace NohYooHan\Service\Product;

use Illuminate\Database\Eloquent\Builder;
use NohYooHan\Domain\Common\Dto\ProductSearchParam;
use NohYooHan\Domain\Product\Product;

class ProductRetriever
{
    public function retrieveBySearchParam(ProductSearchParam $dto)
    {
        $builder = Product::query();

        if ($dto->getSearch()) {
            $builder->where(function (Builder $builder) use ($dto) {
                $builder->where('name', 'like', "%{$dto->getSearch()}%")
                    ->orWhere('description', 'like', "%{$dto->getSearch()}%");
            });
        }

        if ($dto->getPriceFrom() && $dto->getPriceTo()) {
            $builder->whereBetween('price', [
                $dto->getPriceFrom(),
                $dto->getPriceTo()
            ]);
        }

        if ($dto->getPriceFrom() && ! $dto->getPriceTo()) {
            $builder->where('price', '>=', $dto->getPriceFrom());
        }

        if (! $dto->getPriceFrom() && $dto->getPriceTo()) {
            $builder->where('price', '<=', $dto->getPriceTo());
        }

        return $builder->paginate($dto->getSize(), ['*'], 'page', $page = $dto->getPage());
    }
}