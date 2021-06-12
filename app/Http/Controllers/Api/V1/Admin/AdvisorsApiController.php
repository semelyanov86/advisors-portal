<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Actions\DeleteAdvisorAction;
use App\Actions\GetAdvisorByIdAction;
use App\Actions\GetPaginatedAdvisorsAction;
use App\Actions\StoreAdvisorAction;
use App\Actions\UpdateAdvisorAction;
use App\DTO\AdvisorData;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAdvisorApiRequest;
use App\Http\Requests\UpdateAdvisorApiRequest;
use App\Models\Advisor;
use App\Transformers\AdvisorTransformer;
use Illuminate\Http\JsonResponse;
use League\Fractal\Serializer\JsonApiSerializer;
use Symfony\Component\HttpFoundation\Response;
use \Illuminate\Contracts\Routing\ResponseFactory;

final class AdvisorsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(GetPaginatedAdvisorsAction $action): JsonResponse
    {
        $this->checkAccess('advisor_access');

        return fractal(
            $action(),
            new AdvisorTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Advisor::RESOURCE_NAME)
            ->respondJsonApi();
    }

    public function store(
        StoreAdvisorApiRequest $request,
        StoreAdvisorAction $action
    ): JsonResponse {
        $advisor = $action(AdvisorData::fromRequest($request, 'data.attributes.'));

        return fractal(
            $advisor,
            new AdvisorTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Advisor::RESOURCE_NAME)
            ->respondJsonApi(Response::HTTP_CREATED);
    }

    public function show(int $advisor, GetAdvisorByIdAction $action): JsonResponse
    {
        $this->checkAccess('advisor_show');

        return fractal(
            $action($advisor),
            new AdvisorTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Advisor::RESOURCE_NAME)
            ->respondJsonApi();
    }

    public function update(
        UpdateAdvisorApiRequest $request,
        int $advisor,
        UpdateAdvisorAction $action
    ): JsonResponse {
        $data = AdvisorData::fromRequest($request, 'data.attributes.');
        $data->id = $advisor;

        return fractal(
            $action($data),
            new AdvisorTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Advisor::RESOURCE_NAME)
            ->respondJsonApi(Response::HTTP_ACCEPTED);
    }

    public function destroy(
        int $advisor,
        DeleteAdvisorAction $action
    ): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory {
        $this->checkAccess('advisor_delete');

        $action($advisor);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
