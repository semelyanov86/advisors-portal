<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Actions\GetAllLanguagesAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Models\Language;
use App\Transformers\LanguageTransformer;
use League\Fractal\Serializer\JsonApiSerializer;
use Illuminate\Http\JsonResponse;

final class LanguagesApiController extends Controller
{
    public function index(GetAllLanguagesAction $action): JsonResponse
    {
        $this->checkAccess('language_access');

        return fractal(
            $action(),
            new LanguageTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Language::RESOURCE_NAME)
            ->respondJsonApi();
    }

    public function store(StoreLanguageRequest $request): void
    {
        abort(501);
    }

    public function show(Language $language): JsonResponse
    {
        return fractal(
            $language,
            new LanguageTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Language::RESOURCE_NAME)
            ->respondJsonApi();
    }

    public function update(UpdateLanguageRequest $request, Language $language): void
    {
        abort(501);
    }

    public function destroy(Language $language): void
    {
        abort(501);
    }
}
