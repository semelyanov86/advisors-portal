<?php

declare(strict_types=1);

namespace App\ViewModels;

use Illuminate\Support\Collection;

final class AdvisorsViewModel extends \Spatie\ViewModels\ViewModel
{
    public function __construct(
        protected ?Collection $advisors,
        protected ?Collection $languages
    ) {
    }

    public function advisors(): Collection
    {
        return $this->advisors ?? collect([]);
    }

    public function languages(): Collection
    {
        return $this->languages ?? collect([]);
    }
}
