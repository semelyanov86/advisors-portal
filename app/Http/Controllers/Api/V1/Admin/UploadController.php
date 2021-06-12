<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Actions\UploadFileAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileUploadRequest;
use Illuminate\Http\JsonResponse;

final class UploadController extends Controller
{
    public function __invoke(FileUploadRequest $request, UploadFileAction $action): JsonResponse
    {
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            return \Response::json([
                'data' => [
                    'id' => $action($file)
                ]
            ]);
        }
        return \Response::json([
            'error' => 'No file upload key'
        ]);
    }
}
