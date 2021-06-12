<?php

namespace App\Http\Requests;

use App\Models\Advisor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAdvisorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('advisor_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:80',
                'required',
                'unique:advisors,name,' . request()->route('advisor'),
            ],
            'price' => [
                'required',
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
