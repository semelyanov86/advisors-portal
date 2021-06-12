<?php

declare(strict_types=1);

namespace App\Actions;

final class DeleteAdvisorAction extends Action
{
    public function __invoke(int $id): bool
    {
        $receiverAction = app(GetAdvisorByIdAction::class);
        $advisor = $receiverAction($id);
        $advisor->delete();
        return true;
    }
}
