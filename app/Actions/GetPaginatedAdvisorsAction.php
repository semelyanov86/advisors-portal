<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Advisor;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class GetPaginatedAdvisorsAction extends Action
{
    public function __invoke(): LengthAwarePaginator
    {
        return QueryBuilder::for(Advisor::class)->allowedFilters([
            'name'
        ])->allowedIncludes('languages')->jsonPaginate();
    }
}
