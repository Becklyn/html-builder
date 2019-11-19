<?php declare(strict_types=1);

namespace Tests\Becklyn\HtmlBuilder\Node;

use Becklyn\HtmlBuilder\Node\HtmlElement;
use PHPUnit\Framework\TestCase;

class HtmlElementTest extends TestCase
{
    public function testNullIgnored ()
    {
        $element = new HtmlElement("div");
        $element
            ->addContent("a")
            ->addContent(null)
            ->addContent(null)
            ->addContent(null)
            ->addContent("b");

        self::assertCount(2, $element->getContent());
    }
}
