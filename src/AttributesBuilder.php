<?php declare(strict_types=1);

namespace Becklyn\HtmlBuilder;

use Becklyn\HtmlBuilder\Exception\InvalidAttributeNameException;

/**
 * Builds tag attribute strings.
 */
class AttributesBuilder
{
    /**
     * @var AttributesValidator
     */
    private $nameValidator;


    /**
     *
     */
    public function __construct ()
    {
        $this->nameValidator = new AttributesValidator();
    }


    /**
     * Builds arguments to a valid attributes string.
     *
     * @param array $attributes
     *
     * @throws InvalidAttributeNameException
     *
     * @return string
     */
    public function build (array $attributes) : string
    {
        $segments = [];

        foreach ($attributes as $name => $value)
        {
            if (!$this->nameValidator->validateName($name))
            {
                throw new InvalidAttributeNameException(\sprintf("The attribute name `%s` is invalid.", $name));
            }

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
