<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

final class PermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'language_create',
            ],
            [
                'id'    => 18,
                'title' => 'language_edit',
            ],
            [
                'id'    => 19,
                'title' => 'language_show',
            ],
            [
                'id'    => 20,
                'title' => 'language_delete',
            ],
            [
                'id'    => 21,
                'title' => 'language_access',
            ],
            [
                'id'    => 22,
                'title' => 'advisor_create',
            ],
            [
                'id'    => 23,
                'title' => 'advisor_edit',
            ],
            [
                'id'    => 24,
                'title' => 'advisor_show',
            ],
            [
                'id'    => 25,
                'title' => 'advisor_delete',
            ],
            [
                'id'    => 26,
                'title' => 'advisor_access',
            ],
            [
                'id'    => 27,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
