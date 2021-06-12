<?php

declare(strict_types=1);

namespace App\Actions;

use App\Tasks\AttachFileToModelTask;
use App\Tasks\FindFileTask;
use Spatie\MediaLibrary\HasMedia;

final class FindAndAttachFileAction extends Action
{
    public function __invoke(string $folder, HasMedia $destination, string $collection = 'profile'): bool
    {
        $findFileTask = app(FindFileTask::class);
        $fileModel = $findFileTask->run($folder);
        if (!$fileModel) {
            $destination->forceDelete();
            throw new \DomainException('Passed folder is incorrect!');
        }
        $attachFileTask = app(AttachFileToModelTask::class);
        return $attachFileTask->run($fileModel, $destination, $collection);
    }
}
