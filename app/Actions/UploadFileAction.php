<?php

declare(strict_types=1);

namespace App\Actions;

use App\Tasks\SaveInDbTask;
use App\Tasks\StoreFileTask;

final class UploadFileAction extends Action
{
    public function __invoke(\Illuminate\Http\UploadedFile | array | null $file): string
    {
        if (!$file) {
            return '';
        }
        $taskModel = app(StoreFileTask::class);
        $fileData = $taskModel->run($file);
        if (!$fileData) {
            return '';
        }

        $taskSaveModel = app(SaveInDbTask::class);
        $fileModel = $taskSaveModel->run($fileData);
        return $fileModel->folder;
    }
}
