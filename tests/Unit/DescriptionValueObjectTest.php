<?php

namespace Tests\Unit;

use Akaunting\Money\Money;
use App\ValueObjects\DescriptionValueObject;
use App\ValueObjects\MoneyValueObject;
use PHPUnit\Framework\TestCase;

class DescriptionValueObjectTest extends TestCase
{
    public function testIsNullReturnsFalse(): void
    {
        $test = new DescriptionValueObject('Test string');
        $this->assertFalse($test->isNull());
    }


    public function testIsSameFunction(): void
    {
        $test1 = new DescriptionValueObject('test');
        $test2 = new DescriptionValueObject('test');

        $this->assertTrue($test1->isSame($test2));
    }

    public function testIsSameReturnsFalseDoesNotMatch(): void
    {
        $test1 = new DescriptionValueObject('test1');
        $test2 = new DescriptionValueObject('test2');

        $this->assertFalse($test1->isSame($test2));
    }

    public function testFromNativeInstances(): void
    {
        $native = 'This is string';

        $test = DescriptionValueObject::fromNative($native);
        $this->assertEquals($native, $test->toNative());
    }

    public function testCuttingJavascript(): void
    {
        $native = '<script>alert("ya")</script>This is string';

        $test = DescriptionValueObject::fromNative($native);
        $this->assertEquals('This is string', $test->toNative());
    }
}
