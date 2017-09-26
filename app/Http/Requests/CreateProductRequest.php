<?php

namespace App\Http\Requests;

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
