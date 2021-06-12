<?php

declare(strict_types=1);

namespace App\DTO;

use App\ValueObjects\DescriptionValueObject;
use App\ValueObjects\MoneyValueObject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

final class AdvisorData extends ObjectData
{
    public ?int $id;

    public string $name;

    public DescriptionValueObject $description;

    public bool $availability;

    public MoneyValueObject $price;

    public array $languages;

    public ?array $media;

    public ?string $profile;

    public ?array $ck_media;

    public ?string $file_upload;

    public string $source = 'WEB';

    public Carbon $created_at;

    public Carbon $updated_at;

    public static function fromRequest(FormRequest $request, string $prefix = ''): self
    {
        return new self([
            'name' => $request->input($prefix . 'name'),
            'description' => DescriptionValueObject::fromNative($request->input($prefix . 'description')),
            'availability' => $request->boolean($prefix . 'availability'),
            'price' => MoneyValueObject::fromNative($request->input($prefix . 'price')),
            'profile' => $request->input($prefix . 'profile'),
            'ck_media' => $request->input($prefix . 'ck-media', null),
            'languages' => $request->input($prefix . 'languages'),
            'file_upload' => $request->input($prefix . 'file_upload'),
            'source' => $prefix === 'data.attributes' ? 'API' : 'WEB',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
