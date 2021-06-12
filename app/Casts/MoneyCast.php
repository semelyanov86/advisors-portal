<?php

declare(strict_types=1);

namespace App\Casts;

use App\ValueObjects\MoneyValueObject;
use Illuminate\Database\Eloquent\Model;

final class MoneyCast implements \Illuminate\Contracts\Database\Eloquent\CastsAttributes
{

    /**
     * @inheritDoc
     * @param int|MoneyValueObject $value
     * @param Model $model
     */
    public function get($model, string $key, $value, array $attributes): MoneyValueObject
    {
        if (is_object($value)) {
            return $value;
        }
        return MoneyValueObject::fromFullNative($value);
    }

    /**
     * @inheritDoc
     * @param MoneyValueObject|int $value
     * @param Model $model
     */
    public function set($model, string $key, $value, array $attributes): int
    {
        if (is_int($value)) {
            return $value;
        }
        return $value->toInt();
    }
}
