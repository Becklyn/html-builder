<?php declare(strict_types=1);

namespace Tests\Becklyn\HtmlBuilder;

use Becklyn\HtmlBuilder\AttributesValidator;
use PHPUnit\Framework\TestCase;

class AttributesValidatorTest extends TestCase
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
        $validator = new AttributesValidator();
        self::assertTrue($validator->validateName($name));
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
        $validator = new AttributesValidator();
        self::assertFalse($validator->validateName($name));
    }
}
