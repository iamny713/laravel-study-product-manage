<?php

namespace NohYooHan\Domain\Common\Dto;

class ReviewSearchParam
{
    private $size;
    private $page;

    public function __construct(
        int $size = null,
        int $page = null
    ) {
        $this->size = $size;
        $this->page = $page;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getPage()
    {
        return $this->page;
    }
}