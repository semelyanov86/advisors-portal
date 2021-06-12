<?php

namespace App\Http\Requests;

use App\Models\Advisor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAdvisorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('advisor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:advisors,id',
        ];
    }
}
