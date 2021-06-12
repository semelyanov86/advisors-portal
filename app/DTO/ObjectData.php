<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Foundation\Http\FormRequest;

abstract class ObjectData extends \Spatie\DataTransferObject\DataTransferObject
{
    abstract public static function fromRequest(FormRequest $request): self;
}
