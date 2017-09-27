<?php

namespace App\Transformers;

use NohYooHan\Domain\Review\Review;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class ReviewTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'product'
    ];

    protected $defaultIncludes = [];

    protected $visible = [];

    protected $hidden = [];

    public function transform(Review $review)
    {
        $payload = [
            'id' => (int)$review->id,
            // ...
            'created' => $review->created_at->toIso8601String(),
            'link' => [
                'rel' => 'self',
                'href' => route('api.v1.reviews.show', $review->id),
            ],
        ];

        return $this->buildPayload($payload);
    }

    public function includeProduct(Review $review, ParamBag $paramBag = null)
    {
        return $this->item(
            $review->product,
            new \App\Transformers\ProductTransformer($paramBag)
        );
    }
}
