<?php

namespace App\Http\Requests;

use NohYooHan\Domain\Common\Dto\ReviewSearchParam;

class ListReviewRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'size' => 'integer',
            'page' => 'integer',
        ];
    }

    public function getReviewSearchParam()
    {
        return new ReviewSearchParam(
            $this->get('size'),
            $this->get('page')
        );
    }
}
