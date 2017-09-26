<?php

namespace NohYooHan\Domain\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
    //
}
