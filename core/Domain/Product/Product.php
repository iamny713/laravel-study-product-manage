<?php

namespace NohYooHan\Domain\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use NohYooHan\Domain\Review\Review;

/**
 * Class Product
 * @package App
 * @property string $name
 * @property string $description
 * @property int $price
 * @property int $stock
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Product extends Model
{
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
