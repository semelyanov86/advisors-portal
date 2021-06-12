<?php

declare(strict_types=1);

namespace App\Tasks;

use App\DTO\TemporaryFileData;
use Illuminate\Http\UploadedFile;

final class StoreFileTask extends Task
{
    public function run(\Illuminate\Http\UploadedFile | array | null $file): ?TemporaryFileData
    {
        if (!$file) {
            return null;
        }
        if (is_array($file)) {
            /** @var UploadedFile $file */
            $file = $file[0];
        }
        $filename = $file->getClientOriginalName();
        $folder = uniqid('', true) . '-' . now()->timestamp;
        $file->storeAs('public/uploads/tmp/' . $folder, $filename);

        return new TemporaryFileData(array(
            'folder' => $folder,
            'filename' => $filename
        ));
    }
}
