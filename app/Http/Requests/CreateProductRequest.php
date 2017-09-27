<?php

namespace App\Http\Requests;

use NohYooHan\Domain\Common\Dto\ProductDto;
use NohYooHan\Domain\Product\Category;

class CreateProductRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'min:2'],
            'description' => 'required',
            'price' => ['required', 'integer'],
            'stock' => ['required', 'integer'],
            'category' => ['required', 'in:FOOD,COMMODITY'],
        ];
    }

    public function getProductDto()
    {
        return new ProductDto(
            $this->get('name'),
            $this->get('description'),
            $this->get('price'),
            $this->get('stock'),
            Category::getInstance($this->get('category', Category::FOOD))
        );
    }
}
