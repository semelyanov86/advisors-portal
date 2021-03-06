<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Funeralzone\ValueObjects\ValueObject;
use Akaunting\Money\Money;

final class MoneyValueObject extends AbstractValueObject
{
    /**
     * @var Money
     */
    protected Money $money;

    public function __construct(Money $money)
    {
        $this->money = $money;
    }

    /**
     * @inheritDoc
     */
    public function isNull(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     * @psalm-param MoneyValueObject $object
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function isSame(\Funeralzone\ValueObjects\ValueObject $object): bool
    {
        $money2 = $object->getMoney();
        return $this->money->compare($money2) === 0;
    }

    /**
     * @psalm-param int $native
     * @return MoneyValueObject
     * @psalm-suppress UnsafeInstantiation
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromNative($native, ?string $currency = null): MoneyValueObject
    {
        if (!$currency) {
            /** @var string $currency */
            $currency = config('panel.primary_currency');
        }
        return new static(\money($native * 100, $currency));
    }

    public static function fromFullNative(int $native): MoneyValueObject
    {
        return self::fromNative($native / 100);
    }

    /**
     * @inheritDoc
     */
    public function toNative(): array
    {
        return [
            'amount' => $this->money->getAmount(),
            'value' => $this->money->getValue(),
            'currency' => $this->getMoney()->getCurrency()->getSymbol()
        ];
    }

    /**
     * @return Money
     */
    public function getMoney(): Money
    {
        return $this->money;
    }

    public function getFormattedValue(): string
    {
        /** @var string $locale */
        $locale = config('panel.primary_locale');
        return $this->money->formatLocale($locale);
    }

    public function toInt(): int
    {
        return (int) $this->money->getAmount();
    }

    public function toFloat(): float
    {
        return $this->money->getValue();
    }

    public function __toString(): string
    {
        return (string) $this->toInt();
    }
}
