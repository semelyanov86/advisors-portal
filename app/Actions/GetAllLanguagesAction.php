<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Language;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

final class GetAllLanguagesAction extends Action
{
    public function __invoke(): Collection
    {
        return QueryBuilder::for(Language::class)->get();
    }
}
