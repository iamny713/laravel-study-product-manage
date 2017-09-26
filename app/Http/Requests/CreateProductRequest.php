<?php

namespace App\Http\Requests;

use NohYooHan\Domain\Common\Dto\ProductDto;

class CreateProductRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'min:2'],
            'description' => 'required',
            'price' => ['required', 'integer'],
            'stock' => ['required', 'integer'],
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
