<?php declare(strict_types=1);

namespace Becklyn\HtmlBuilder\Builder;

use Becklyn\HtmlBuilder\Node\HtmlAttributes;
use Becklyn\HtmlBuilder\Node\HtmlElement;

class HtmlBuilder
{
    /**
     * Builds an HTML element.
     *
     * @param HtmlElement $element
     *
     * @return string
     */
    public function buildElement (HtmlElement $element) : string
    {
        $html = "<{$element->getTagName()}";
        $attrs = $this->buildAttributes($element->getAttributes());
        $content = [];

        if ("" !== $attrs)
        {
            $html .= " {$attrs}";
        }

        $html .= ">";

        foreach ($element->getContent() as $entry)
        {
            $content[] = $entry instanceof HtmlElement
                ? $this->buildElement($entry)
                : \htmlspecialchars($entry);
        }

        $html .= \implode("", $content);

        if (!$element->isEmpty())
        {
            $html .= "</{$element->getTagName()}>";
        }

        return $html;
    }


    /**
     * Builds the attributes string.
     *
     * @param HtmlAttributes $attributes
     *
     * @return string
     */
    public function buildAttributes (HtmlAttributes $attributes) : string
    {
        $segments = [];

        foreach ($attributes as $name => $value)
        {
            if (null === $value || false === $value)
            {
                continue;
            }

            if (true === $value)
            {
                $segments[] = $name;
                continue;
            }

            $segments[] = \sprintf(
                '%s="%s"',
                $name,
                \htmlspecialchars((string) $value, \ENT_COMPAT)
            );
        }

        return \implode(" ", $segments);
    }
}
