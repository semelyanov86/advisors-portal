<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Advisor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

final class StoreAdvisorApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('advisor_create');
    }

    public function rules(): array
    {
        return [
            'data' => [
                'required', 'array'
            ],
            'data.type' => ['required', \Illuminate\Validation\Rule::in(['advisors'])],
            'data.attributes' => 'required|array',
            'data.attributes.name' => [
                'string',
                'max:80',
                'required',
                'unique:advisors,name',
            ],
            'data.attributes.price' => [
                'required', 'numeric'
            ],
            'data.attributes.availability' => [
                'boolean'
            ],
            'data.attributes.description' => [
                'nullable'
            ],
            'data.attributes.file_upload' => [
                'nullable', 'string'
            ],
            'data.attributes.languages.*' => [
                'integer',
            ],
            'data.attributes.languages' => [
                'array',
            ],
        ];
    }
}
