<?php declare(strict_types=1);

namespace Becklyn\HtmlBuilder\Node;

use Becklyn\HtmlBuilder\Exception\InvalidAttributeNameException;
use Becklyn\HtmlBuilder\Exception\InvalidAttributeValueException;

class HtmlAttributes implements \IteratorAggregate
{
    private $attributes = [];


    /**
     * @param array $initial
     */
    public function __construct (array $initial = [])
    {
        foreach ($initial as $name => $value)
        {
            $this->set($name, $value);
        }
    }


    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return HtmlAttributes
     */
    public function set (string $name, $value) : self
    {
        if (!$this->validateName($name))
        {
            throw new InvalidAttributeNameException(\sprintf("The attribute name `%s` is invalid.", $name));
        }

        if (!\is_scalar($name))
        {
            throw new InvalidAttributeValueException(\sprintf(
                "An attribute value of type '%s' is invalid.",
                \gettype($value)
            ));
        }

        $this->attributes[$name] = $value;
        return $this;
    }


    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function get (string $name)
    {
        return $this->attributes[$name] ?? null;
    }


    /**
     * @inheritDoc
     */
    public function getIterator ()
    {
        return new \ArrayIterator($this->attributes);
    }


    /**
     * Validates that the given attribute name is valid.
     *
     * @param string $attributeName
     *
     * @return bool
     */
    private function validateName (string $attributeName) : bool
    {
        // See: https://www.w3.org/TR/html5/syntax.html#elements-attributes
        //
        // Attribute names must consist of one or more characters other than the space characters,
        // U+0000 NULL, U+0022 QUOTATION MARK ("), U+0027 APOSTROPHE ('), U+003E GREATER-THAN SIGN (>),
        // U+002F SOLIDUS (/), and U+003D EQUALS SIGN (=) characters, the control characters, and any
        // characters that are not defined by Unicode.
        //
        // We additionally don't allow an less than sign
        return "" !== $attributeName
            ? !\preg_match('~[ \\x{0000}-\\x{001F}\\x{0080}-\\x{009F}"\'<>/=]~u', $attributeName)
            : false;
    }
}
