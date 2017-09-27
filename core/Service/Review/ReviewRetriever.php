<?php

namespace NohYooHan\Service\Review;

use NohYooHan\Domain\Common\Dto\ReviewSearchParam;
use NohYooHan\Domain\Review\Review;

class ReviewRetriever
{
    public function retrieveByProductId(int $productId, ReviewSearchParam $dto)
    {
        $builder = Review::query();

        $builder->where('product_id', $productId);
        return $builder->paginate($dto->getSize(), ['*'], 'page', $page = $dto->getPage());
    }
}