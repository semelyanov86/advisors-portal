<?php

declare(strict_types=1);

namespace App\Transformers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class MediaTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(Media $media): array
    {
        return [
            'id' => $media->id,
            'url' => $media->getFullUrl(),
            'size' => $media->size,
            'mime_type' => $media->mime_type,
            'responsive' => $media->getResponsiveImageUrls()
        ];
    }
}
