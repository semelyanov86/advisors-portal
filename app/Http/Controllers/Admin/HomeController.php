<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;

final class HomeController
{
    public function index(): Factory|View|Application
    {
        return view('home');
    }
}
