<?php

declare(strict_types=1);

namespace App\Tasks;

use App\DTO\TemporaryFileData;
use App\Models\TemporaryFile;
use App\Repositories\TemporaryFileRepositoryInterface;

final class SaveInDbTask extends Task
{
    protected TemporaryFileRepositoryInterface $repository;

    public function __construct(
        TemporaryFileRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function run(TemporaryFileData $fileData): TemporaryFile
    {
        return $this->repository->create($fileData->toArray());
    }
}
