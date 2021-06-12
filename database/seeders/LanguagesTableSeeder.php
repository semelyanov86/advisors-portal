<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

final class LanguagesTableSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            [
                'id'    => 1,
                'name' => 'English',
            ],
            [
                'id'    => 2,
                'name' => 'German',
            ],
        ];

        Language::insert($languages);
    }
}
