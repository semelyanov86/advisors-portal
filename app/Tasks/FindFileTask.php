<?php

declare(strict_types=1);

namespace App\Tasks;

use App\Models\TemporaryFile;
use App\Repositories\TemporaryFileRepositoryInterface;

final class FindFileTask extends Task
{
    protected TemporaryFileRepositoryInterface $repository;

    public function __construct(
        TemporaryFileRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function run(string $folder): ?TemporaryFile
    {
        return $this->repository->findByFolder($folder);
    }
}
