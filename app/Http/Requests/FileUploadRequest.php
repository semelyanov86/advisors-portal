<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FileUploadRequest
 * @package Domains\TemporaryFile\Http\Requests
 */
final class FileUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file_upload' => [
                'file', 'mimes:jpg,png,bmp,pdf', 'max:2040'
            ]
        ];
    }
}
