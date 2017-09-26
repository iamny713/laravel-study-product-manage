<?php

namespace NohYooHan\Domain\Review;

use Illuminate\Database\Eloquent\Model;
use NohYooHan\Domain\Product\Product;

class Review extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
