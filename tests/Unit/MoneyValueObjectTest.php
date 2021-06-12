<?php

namespace Tests\Unit;

use Akaunting\Money\Money;
use App\ValueObjects\MoneyValueObject;
use PHPUnit\Framework\TestCase;

class MoneyValueObjectTest extends TestCase
{
    public function testIsNullReturnsFalse(): void
    {
        $test = new MoneyValueObject(money(5000, 'RUB'));
        $this->assertFalse($test->isNull());
    }


    public function testIsSameReturnsTrueWherAmountAndCurrencyMatch(): void
    {
        $money = money(10000, 'RUB');

        $test1 = new MoneyValueObject($money);
        $test2 = new MoneyValueObject($money);

        $this->assertTrue($test1->isSame($test2));
    }

    public function testIsSameReturnsFalseAmountDoesNotMatch(): void
    {
        $money1 = money(1000, 'RUB');
        $money2 = money(1001, 'RUB');

        $test1 = new MoneyValueObject($money1);
        $test2 = new MoneyValueObject($money2);

        $this->assertFalse($test1->isSame($test2));
    }

    public function testIsSameReturnsExceptionCurrencyDoesNotMatch(): void
    {
        $money1 = money(5000, 'RUB');
        $money2 = money(5000, 'EUR');

        $test1 = new MoneyValueObject($money1);
        $test2 = new MoneyValueObject($money2);

        $this->expectException(\InvalidArgumentException::class);
        $test1->isSame($test2);
    }

    public function testFromNativeInstances(): void
    {
        $native = 6300;

        $test = MoneyValueObject::fromNative($native, 'EUR');
        $this->assertEquals(630000, $test?->toInt());
    }


    public function testToNativeReturnsCorrectRepresentationOfMoney(): void
    {
        $money = money(1200, 'RUB');

        $test = new MoneyValueObject($money);
        $this->assertEquals([
            'amount' => 1200,
            'value' => $test->toFloat(),
            'currency' => '₽'
        ], $test->toNative());
    }

    public function testReturnsCorrectMoneyObject(): void
    {
        $money = money(5000, 'RUB');

        $test = new MoneyValueObject($money);
        $this->assertEquals(5000, $test->getMoney()->getAmount());
        $this->assertEquals('Russian Ruble', $test->getMoney()->getCurrency()->getName());
    }

    public function testToIntReturnsCorrectValue(): void
    {
        $money = money(10000, 'RUB');

        $test1 = new MoneyValueObject($money);
        $this->assertEquals(10000, $test1->toInt());
    }
}
