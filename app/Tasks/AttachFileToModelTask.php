<?php

declare(strict_types=1);

namespace App\Tasks;

use App\Models\TemporaryFile;
use App\Repositories\TemporaryFileRepositoryInterface;
use Spatie\MediaLibrary\HasMedia;

final class AttachFileToModelTask extends Task
{
    protected TemporaryFileRepositoryInterface $repository;

    public function __construct(
        TemporaryFileRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function run(TemporaryFile $file, HasMedia $destination, string $collection = 'profile'): bool
    {
        $destination->addMedia(storage_path('app/public/uploads/tmp/' . $file->folder . '/' . $file->filename))
            ->toMediaCollection($collection);
        rmdir(storage_path('app/public/uploads/tmp/' . $file->folder . '/'));
        $this->repository->delete($file->id);
        return true;
    }
}
