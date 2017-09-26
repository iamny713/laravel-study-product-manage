<?php

namespace App\Http\Requests;

use NohYooHan\Domain\Common\Dto\ProductSearchParam;

class ListProductRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'price_from' => 'integer',
            'price_to' => 'integer',
            'size' => 'integer',
            'page' => 'integer',
        ];
    }

    public function getProductSearchParam()
    {
        return new ProductSearchParam(
            $this->get('search'),
            $this->get('price_from'),
            $this->get('price_to'),
            $this->get('size'),
            $this->get('page')
        );
    }
}
