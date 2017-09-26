<?php

namespace App\Http\Requests;

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

    public function getName()
    {
        return $this->get('name');
    }

    public function getPrice()
    {
        return $this->get('price');
    }

    public function getStock()
    {
        return $this->get('stock');
    }

    public function getDescription()
    {
        return $this->get('description');
    }
}
