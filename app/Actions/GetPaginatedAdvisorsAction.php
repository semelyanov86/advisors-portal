<?php

declare(strict_types=1);

namespace App\Actions;

use App\Filters\FilterByLanguages;
use App\Models\Advisor;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class GetPaginatedAdvisorsAction extends Action
{
    public function __invoke(): LengthAwarePaginator
    {
        return QueryBuilder::for(Advisor::class)->allowedFilters([
            'name',
            AllowedFilter::custom(
                'languages',
                new FilterByLanguages()
            ),
        ])->allowedIncludes('languages')->jsonPaginate();
    }
}
