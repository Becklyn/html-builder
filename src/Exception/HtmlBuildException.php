<?php declare(strict_types=1);

namespace Becklyn\HtmlBuilder\Exception;

class HtmlBuildException extends \InvalidArgumentException
{
    /**
     * @inheritDoc
     */
    public function __construct (string $message, ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
