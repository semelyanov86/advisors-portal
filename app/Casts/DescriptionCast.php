<?php

declare(strict_types=1);

namespace App\Casts;

use App\ValueObjects\DescriptionValueObject;
use Illuminate\Database\Eloquent\Model;

final class DescriptionCast implements \Illuminate\Contracts\Database\Eloquent\CastsAttributes
{

    /**
     * @inheritDoc
     * @param ?string $value
     * @param Model $model
     */
    public function get($model, string $key, $value, array $attributes): ?DescriptionValueObject
    {
        if (!$value) {
            return null;
        }
        return DescriptionValueObject::fromNative($value);
    }

    /**
     * @inheritDoc
     * @param DescriptionValueObject|string|null $value
     * @param Model $model
     */
    public function set($model, string $key, $value, array $attributes): ?string
    {
        if (!$value) {
            return null;
        }
        if (is_string($value)) {
            return $value;
        }
        return $value->toNative();
    }
}
