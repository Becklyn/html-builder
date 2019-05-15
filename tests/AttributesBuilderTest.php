<?php declare(strict_types=1);

namespace Tests\Becklyn\HtmlBuilder;

use Becklyn\HtmlBuilder\AttributesBuilder;
use Becklyn\HtmlBuilder\Exception\InvalidAttributeNameException;
use PHPUnit\Framework\TestCase;

class AttributesBuilderTest extends TestCase
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
        $builder = new AttributesBuilder();
        self::assertSame($expected, $builder->build($attributes));
    }


    /**
     *
     */
    public function testInvalidName ()
    {
        $this->expectException(InvalidAttributeNameException::class);
        $builder = new AttributesBuilder();
        $builder->build(['sorry invalid' => 123]);
    }
}
