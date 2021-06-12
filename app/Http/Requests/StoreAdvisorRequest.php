<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Advisor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

final class StoreAdvisorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('advisor_create');
    }

    public function rules(): array
    {
        return [
            'name' => [
                'string',
                'max:80',
                'required',
                'unique:advisors',
            ],
            'price' => [
                'required', 'numeric'
            ],
            'availability' => [
                'boolean'
            ],
            'description' => [
                'nullable'
            ],
            'languages.*' => [
                'integer',
            ],
            'languages' => [
                'array',
            ],
        ];
    }
}
