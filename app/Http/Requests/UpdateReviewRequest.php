<?php

namespace App\Http\Requests;


use NohYooHan\Domain\Common\Dto\ReviewDto;

class UpdateReviewRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'content' => 'required',
        ];
    }

    public function getReviewDto()
    {
        return new ReviewDto(
            $this->get('content')
        );
    }
}
