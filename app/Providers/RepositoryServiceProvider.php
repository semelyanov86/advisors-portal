<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Eloquent\TemporaryFileRepository;
use App\Repositories\TemporaryFileRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(TemporaryFileRepositoryInterface::class, TemporaryFileRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}
