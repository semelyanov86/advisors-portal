<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Advisor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

final class UpdateAdvisorApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('advisor_edit');
    }

    public function rules(): array
    {
        return [
            'data' => [
                'required', 'array'
            ],
            'data.id' => ['required', 'string'],
            'data.type' => ['required', \Illuminate\Validation\Rule::in(['advisors'])],
            'data.attributes' => 'required|array',
            'data.attributes.name' => [
                'string',
                'max:80',
                'required',
                'unique:advisors,name,' . request()->route('advisor'),
            ],
            'data.attributes.price' => [
                'required',
            ],
            'data.attributes.languages.*' => [
                'integer',
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
            'data.attributes.languages' => [
                'array',
            ],
        ];
    }
}
