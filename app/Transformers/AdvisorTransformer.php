<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\Advisor;
use App\Models\Language;

final class AdvisorTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['languages'];

    public function transform(Advisor $advisor): array
    {
        $image = $advisor->getFirstMedia('profile');
        $transformer = new MediaTransformer();
        return [
            'id' => $advisor->id,
            'name' => $advisor->name,
            'description' => $advisor->description?->toNative(),
            'availability' => $advisor->availability,
            'price' => $advisor->price->toNative(),
            'media' => $image ? $transformer->transform($image) : null,
            'meta' => [
                'created_at' => $advisor->created_at,
                'updated_at' => $advisor->updated_at
            ]
        ];
    }

    public function includeLanguages(Advisor $advisor): \League\Fractal\Resource\Collection
    {
        return $this->collection($advisor->languages, new LanguageTransformer(), Language::RESOURCE_NAME);
    }
}
