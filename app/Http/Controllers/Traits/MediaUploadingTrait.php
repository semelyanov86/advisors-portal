<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;

trait MediaUploadingTrait
{
    public function storeMedia(Request $request): \Illuminate\Http\JsonResponse
    {
        // Validates file size
        if (RequestFacade::has('size')) {
            $this->validate(request(), [
                'file' => 'max:' . request()->input('size') * 1024,
            ]);
        }
        // If width or height is preset - we are validating it as an image
        if (RequestFacade::has('width') || RequestFacade::has('height')) {
            $this->validate(request(), [
                'file' => sprintf(
                    'image|dimensions:max_width=%s,max_height=%s',
                    RequestFacade::input('width', 100000),
                    RequestFacade::input('height', 100000)
                ),
            ]);
        }

        $path = storage_path('tmp/uploads');

        try {
            if (!file_exists($path)) {
                if (!mkdir($path, 0755, true) && !is_dir($path)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
                }
            }
        } catch (\Exception $e) {
        }

        $file = $request->file('file');

        $name = uniqid('', true) . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
}
