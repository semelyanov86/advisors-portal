<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Language;

final class GetSelectLanguagesAction extends Action
{

    public function __invoke(): \Illuminate\Support\Collection
    {
        return Language::all()->pluck('name', 'id');
    }
}
