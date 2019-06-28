<?php declare(strict_types=1);

namespace Tests\Becklyn\HtmlBuilder\Node;

use Becklyn\HtmlBuilder\Node\HtmlAttributes;
use Becklyn\HtmlBuilder\Exception\InvalidAttributeNameException;
use PHPUnit\Framework\TestCase;

class HtmlAttributesTest extends TestCase
{
    /**
     * @return array
     */
    public function provideValid () : array
    {
        return [
            ["href"],
            ["target"],
            ["data-test"],
            ["test_test"],
            ["on:click"],
            ["CAPS"],
        ];
    }


    /**
     * @dataProvider provideValid
     * @param string $name
     */
    public function testValid (string $name) : void
    {
        $attrs = new HtmlAttributes([$name => "ohai"]);
        self::assertSame("ohai", $attrs->get($name));
    }


    /**
     * @return array
     */
    public function provideInvalid () : array
    {
        return [
            ["NULL\u{0}"],
            ["BEL\u{7}"],
            ["a b"],
            ["ab "],
            [" ab"],
            ["a>b"],
            ["a/b"],
            ["a=b"],
            ['a"b'],
            ["a'b"],
            [""],
            [" "],
        ];
    }


    /**
     * @dataProvider provideInvalid
     * @param string $name
     */
    public function testInvalid (string $name) : void
    {
        $this->expectException(InvalidAttributeNameException::class);
        new HtmlAttributes([$name => "ohai"]);
    }
}
