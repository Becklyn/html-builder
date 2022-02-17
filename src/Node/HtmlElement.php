<?php declare(strict_types=1);

namespace Becklyn\HtmlBuilder\Node;

use Becklyn\HtmlBuilder\Element\ElementCollection;
use Becklyn\HtmlBuilder\Exception\InvalidElementContentException;
use Becklyn\HtmlBuilder\Exception\NoContentAllowedException;

class HtmlElement
{
    private string $tagName;
    private bool $empty;
    private HtmlAttributes $attributes;
    /** @var (string|HtmlElement|SafeMarkup)[] */
    private array $content = [];


    /**
     * @param array|HtmlAttributes $attributes
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


    public function getTagName () : string
    {
        return $this->tagName;
    }


    public function getAttributes () : HtmlAttributes
    {
        return $this->attributes;
    }


    /**
     * @return (string|HtmlElement|SafeMarkup)[]
     */
    public function getContent () : array
    {
        return $this->content;
    }


    public function isEmpty () : bool
    {
        return $this->empty;
    }


    /**
     * @param string|HtmlElement|SafeMarkup|mixed $value
     */
    public function addContent ($value) : self
    {
        if ($this->empty)
        {
            throw new NoContentAllowedException(\sprintf(
                "Elements of type '%s' can't have content.",
                $this->tagName
            ));
        }

        // ignore `null` values
        if (null === $value)
        {
            return $this;
        }

        if (\is_scalar($value))
        {
            $this->content[] = (string) $value;
            return $this;
        }

        if ($value instanceof self || $value instanceof SafeMarkup)
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
