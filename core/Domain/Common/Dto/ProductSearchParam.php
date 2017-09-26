<?php

namespace NohYooHan\Domain\Common\Dto;

class ProductSearchParam
{
    private $search;
    private $priceFrom;
    private $priceTo;
    private $size;
    private $page;

    public function __construct(
        string $search = null,
        int $priceFrom = null,
        int $priceTo = null,
        int $size = null,
        int $page = null
    ) {
        $this->search = $search;
        $this->priceFrom = $priceFrom;
        $this->priceTo = $priceTo;
        $this->size = $size;
        $this->page = $page;
    }

    public function getSearch()
    {
        return $this->search;
    }

    public function getPriceFrom()
    {
        return $this->priceFrom;
    }

    public function getPriceTo()
    {
        return $this->priceTo;
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