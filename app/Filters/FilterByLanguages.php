<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

final class FilterByLanguages implements \Spatie\QueryBuilder\Filters\Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
        if (is_string($value)) {
            $value = [$value];
        }

        $query->whereHas('languages', function (Builder $q) use ($value) {
            $q->whereIn('id', $value);
        }, '=', count($value));
    }
}
