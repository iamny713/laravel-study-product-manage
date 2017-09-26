<?php

namespace App\Http\Requests;

use NohYooHan\Domain\Common\Dto\ProductDto;

class UpdateProductRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => ['min:2'],
            'price' => ['integer'],
            'stock' => ['integer'],
        ];
    }

    public function getProductDto()
    {
        return new ProductDto(
            $this->get('name'),
            $this->get('description'),
            $this->get('price'),
            $this->get('stock')
        );
    }
}
