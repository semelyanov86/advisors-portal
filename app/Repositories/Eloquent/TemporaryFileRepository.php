<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\TemporaryFile;
use App\Repositories\TemporaryFileRepositoryInterface;

/**
 * Class TemporaryFileRepository
 * @package Domains\TemporaryFile\Repositories\Eloquent
 */
final class TemporaryFileRepository implements TemporaryFileRepositoryInterface
{
    public function create(array $attributes): TemporaryFile
    {
        unset($attributes['id']);
        /** @var TemporaryFile $file */
        $file = TemporaryFile::create($attributes);
        return $file;
    }

    /**
     * @param int $id
     * @psalm-suppress ImplementedReturnTypeMismatch
     */
    public function delete($id): bool
    {
        return (bool) TemporaryFile::where('id', $id)->firstOrFail()->delete();
    }

    public function findByFolder(string $folder): ?TemporaryFile
    {
        return TemporaryFile::where('folder', $folder)->first();
    }
}
