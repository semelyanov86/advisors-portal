<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Language;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

final class StoreLanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('language_create');
    }

    public function rules(): array
    {
        return [
            'name' => [
                'string',
                'min:2',
                'max:100',
                'required',
                'unique:languages',
            ],
        ];
    }
}
