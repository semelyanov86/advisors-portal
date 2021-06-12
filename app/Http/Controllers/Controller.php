<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected function checkAccess(string $access): void
    {
        abort_if(Gate::denies($access), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    protected function getUrl(): string
    {
        /** @var string $url */
        $url = config('app.url');
        return $url;
    }
}
