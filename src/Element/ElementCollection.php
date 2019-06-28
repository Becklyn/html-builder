<?php declare(strict_types=1);

namespace Becklyn\HtmlBuilder\Element;

class ElementCollection
{
    private const EMPTY_ELEMENTS = [
        "area" => true,
        "base" => true,
        "br" => true,
        "col" => true,
        "embed" => true,
        "hr" => true,
        "img" => true,
        "input" => true,
        "link" => true,
        "meta" => true,
        "param" => true,
        "source" => true,
        "track" => true,
        "wbr" => true,
    ];


    /**
     * @param string $tagName
     *
     * @return bool
     */
    public static function isEmptyElement (string $tagName) : bool
    {
        return isset(self::EMPTY_ELEMENTS[$tagName]);
    }
}
