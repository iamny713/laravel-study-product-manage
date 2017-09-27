<?php

namespace NohYooHan\Service\Review;

use NohYooHan\Domain\Common\Dto\ReviewDto;
use NohYooHan\Domain\Review\Review;

class ReviewCreator
{
    public function makeReview(ReviewDto $dto, int $productId)
    {
        /** @var Product $product */
        $review = new Review;
        $review->product_id = $productId;
        $review->content = $dto->getContent();
        return $review;
    }
}