<?php declare(strict_types=1);

namespace Becklyn\HtmlBuilder;

/**
 * Builds tag attribute strings.
 */
class AttributesBuilder
{
    /**
     * Builds arguments to a valid attributes string.
     *
     * @param array $attributes
     *
     * @return string
     */
    public function build (array $attributes) : string
    {
        $segments = [];

        foreach ($attributes as $key => $value)
        {
            if (null === $value || false === $value)
            {
                continue;
            }

            if (true === $value)
            {
                $segments[] = $key;
                continue;
            }

            $segments[] = \sprintf(
                '%s="%s"',
                $key,
                \htmlspecialchars((string) $value, \ENT_COMPAT)
            );
        }

        return \implode(" ", $segments);
    }
}
