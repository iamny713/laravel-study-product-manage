<?php

namespace NohYooHan\Service\Review;

use NohYooHan\Domain\Common\Dto\ReviewDto;
use NohYooHan\Domain\Review\Review;

class ReviewModifier
{
    public function modifyReview(Review $review, ReviewDto $dto)
    {
        $review->content = $dto->getContent();
    }
}