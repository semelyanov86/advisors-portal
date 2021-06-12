<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\AdvisorData;
use App\Models\Advisor;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class StoreAdvisorAction extends Action
{

    public function __invoke(AdvisorData $advisorData): Advisor
    {
        $advisor = Advisor::create($advisorData->toArray());
        $advisor->languages()->sync($advisorData->languages);
        if ($advisorData->profile) {
            $advisor->addMedia(storage_path('tmp/uploads/' . basename($advisorData->profile)))->toMediaCollection('profile');
        }

        if ($media = $advisorData->ck_media) {
            Media::whereIn('id', $media)->update(['model_id' => $advisor->id]);
        }

        $fileAction = app(FindAndAttachFileAction::class);
        if ($advisorData->file_upload) {
            $fileAction($advisorData->file_upload, $advisor, 'profile');
        }
        return $advisor;
    }
}
