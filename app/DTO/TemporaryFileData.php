<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * Class TemporaryFileData
 * @package Domains\TemporaryFile\DataTransferObject
 */
final class TemporaryFileData extends ObjectData
{
    public ?int $id;

    public string $folder;

    public string $filename;

    public ?Carbon $created_ad;

    public ?Carbon $updated_at;

    /**
     * @param  Request  $request
     * @return static
     * @psalm-suppress MixedArgument
     */
    public static function fromRequest(Request $request): self
    {
        return new self([

        ]);
    }
}
