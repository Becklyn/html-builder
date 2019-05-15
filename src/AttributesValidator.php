<?php declare(strict_types=1);

namespace Becklyn\HtmlBuilder;

class AttributesValidator
{
    /**
     * Validates that the given attribute name is valid.
     *
     * @param string $attributeName
     *
     * @return bool
     */
    public function validateName (string $attributeName) : bool
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
