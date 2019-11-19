<?php declare(strict_types=1);

namespace Tests\Becklyn\HtmlBuilder\Builder;

use Becklyn\HtmlBuilder\Builder\HtmlBuilder;
use Becklyn\HtmlBuilder\Node\HtmlAttributes;
use Becklyn\HtmlBuilder\Node\HtmlElement;
use Becklyn\HtmlBuilder\Node\SafeMarkup;
use PHPUnit\Framework\TestCase;

class HtmlBuilderTest extends TestCase
{
    /**
     * @return array
     */
    public function provideAttributes () : array
    {
        return [
            "simple" => [["href" => "/"], 'href="/"'],
            "multiple" => [["a" => 1, "b" => "234"], 'a="1" b="234"'],
            "false" => [["a" => false, "b" => "234"], 'b="234"'],
            "null" => [["a" => null, "b" => "234"], 'b="234"'],
            "true" => [["a" => true, "b" => "234"], 'a b="234"'],
        ];
    }


    /**
     * @dataProvider provideAttributes
     *
     * @param array  $attributes
     * @param string $expected
     */
    public function testAttributes (array $attributes, string $expected) : void
    {
        $builder = new HtmlBuilder();
        self::assertSame($expected, $builder->buildAttributes(new HtmlAttributes($attributes)));
    }


    public function provideElements ()
    {
        return [
            [
                new HtmlElement("img", ["src" => "test"]),
                '<img src="test">',
            ],
            [
                new HtmlElement("p", [], ["Test <b>not bold</b>"]),
                '<p>Test &lt;b&gt;not bold&lt;/b&gt;</p>',
            ],
            [
                new HtmlElement("p", [], ["a ", new SafeMarkup("This is <b>bold</b>!"), " c"]),
                '<p>a This is <b>bold</b>! c</p>',
            ],
        ];
    }


    /**
     * @dataProvider provideElements
     *
     * @param HtmlElement $element
     * @param string      $expected
     */
    public function testElements (HtmlElement $element, string $expected)
    {
        $builder = new HtmlBuilder();
        self::assertSame($expected, $builder->buildElement($element));
    }
}
