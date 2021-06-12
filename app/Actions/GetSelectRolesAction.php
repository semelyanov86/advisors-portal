<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Role;
use Illuminate\Support\Collection;

final class GetSelectRolesAction extends Action
{
    public function __invoke(): Collection
    {
        return Role::all()->pluck('title', 'id');
    }
}
