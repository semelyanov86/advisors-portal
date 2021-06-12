<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Advisor;
use Spatie\QueryBuilder\QueryBuilder;

final class GetAdvisorByIdAction extends Action
{
    public function __invoke(int $id): Advisor
    {
        $advisor = QueryBuilder::for(Advisor::class)
            ->where('id', $id)->firstOrFail();
        $advisor->load('languages');
        return $advisor;
    }
}
