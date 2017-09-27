<?php
/**
 * Created by IntelliJ IDEA.
 * User: iamny
 * Date: 2017. 9. 27.
 * Time: 오전 10:48
 */

namespace NohYooHan\Domain\Common\Dto;


class ReviewDto
{
    private $content;
    private $writer;

    public function __construct(
        string $content
    )
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getWriter()
    {
        return $this->writer;
    }

}