<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\Language;

final class LanguageTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(Language $language): array
    {
        return [
            'id' => $language->id,
            'name' => $language->name,
            'meta' => [
                'created_at' => $language->created_at,
                'updated_at' => $language->updated_at
            ]
        ];
    }
}
