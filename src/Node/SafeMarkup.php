<?php declare(strict_types=1);

namespace Becklyn\HtmlBuilder\Node;

/**
 * Markup that is marked as "being safe"
 */
class SafeMarkup
{
    private string $content;


    public function __construct (string $content)
    {
        $this->content = $content;
    }


    public function getContent () : string
    {
        return $this->content;
    }
}
