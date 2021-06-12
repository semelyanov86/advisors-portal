<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\AdvisorData;
use App\Models\Advisor;

final class UpdateAdvisorAction extends Action
{
    public function __construct(
        protected GetAdvisorByIdAction $receiverAction
    ) {
    }

    public function __invoke(AdvisorData $data): Advisor
    {
        $receiverAction = app(GetAdvisorByIdAction::class);
        $advisor = $receiverAction($data->id);
        $advisor->update($data->toArray());
        $advisor->languages()->sync($data->languages);
        if ($data->profile) {
            if (!$advisor->profile || $data->profile !== $advisor->profile->file_name) {
                if ($advisor->profile) {
                    $advisor->profile->delete();
                }
                $advisor->addMedia(storage_path('tmp/uploads/' . basename($data->profile)))->toMediaCollection('profile');
            }
        } elseif ($advisor->profile && $data->source === 'WEB') {
            $advisor->profile->delete();
        }
        $fileAction = app(FindAndAttachFileAction::class);
        if ($data->file_upload) {
            if ($advisor->profile) {
                $advisor->profile->delete();
            }
            $fileAction($data->file_upload, $advisor, 'profile');
        }
        return $advisor;
    }
}
