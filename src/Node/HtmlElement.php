<?php declare(strict_types=1);

namespace Becklyn\HtmlBuilder\Node;

use Becklyn\HtmlBuilder\Element\ElementCollection;
use Becklyn\HtmlBuilder\Exception\InvalidElementContentException;
use Becklyn\HtmlBuilder\Exception\NoContentAllowedException;

class HtmlElement
{
    /**
     * @var string
     */
    private $tagName;


    /**
     * @var bool
     */
    private $empty;


    /**
     * @var HtmlAttributes
     */
    private $attributes;


    /**
     * @var (string|HtmlElement)[]
     */
    private $content = [];


    /**
     * @param string               $tagName
     * @param array|HtmlAttributes $attributes
     * @param array                $content
     */
    public function __construct (string $tagName, $attributes = [], array $content = [])
    {
        $this->tagName = $tagName;
        $this->empty = ElementCollection::isEmptyElement($tagName);
        $this->attributes = $attributes instanceof  HtmlAttributes
            ? $attributes
            : new HtmlAttributes($attributes);

        foreach ($content as $entry)
        {
            $this->addContent($entry);
        }
    }


    /**
     * @return string
     */
    public function getTagName () : string
    {
        return $this->tagName;
    }


    /**
     * @return HtmlAttributes
     */
    public function getAttributes () : HtmlAttributes
    {
        return $this->attributes;
    }


    /**
     * @return (string|HtmlElement)[]
     */
    public function getContent () : array
    {
        return $this->content;
    }


    /**
     * @return bool
     */
    public function isEmpty () : bool
    {
        return $this->empty;
    }


    /**
     * @param string|HtmlElement $value
     */
    public function addContent ($value)
    {
        if ($this->empty)
        {
            throw new NoContentAllowedException(\sprintf(
                "Elements of type '%s' can't have content.",
                $this->tagName
            ));
        }

        if (\is_scalar($value))
        {
            $this->content[] = (string) $value;
            return $this;
        }

        if ($value instanceof self)
        {
            $this->content[] = $value;
            return $this;
        }

        throw new InvalidElementContentException(\sprintf(
            "Can't add value of type '%s' as content to a HtmlElement.",
            \gettype($value)
        ));
    }

}
