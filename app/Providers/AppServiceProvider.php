<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Fractal\Facades\Fractal;
use Illuminate\Http\JsonResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fractal::macro('respondJsonApi', function (
            int $statusCode = 200,
            array $headers = []
        ): JsonResponse {
            return $this->respond($statusCode, array_merge($headers, [
                'Content-Type' => 'application/vnd.api+json',
            ]));
        });
    }
}
