<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Advisor;
use App\Models\Language;
use App\ViewModels\AdvisorsViewModel;

final class GetAdvisorsAndLanguagesAction extends Action
{

    public function __invoke(): AdvisorsViewModel
    {
        return new AdvisorsViewModel(
            Advisor::with(['languages', 'media'])->get(),
            Language::get()
        );
    }
}
