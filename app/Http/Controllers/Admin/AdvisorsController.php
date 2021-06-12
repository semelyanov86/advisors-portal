<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\DeleteAdvisorAction;
use App\Actions\GetAdvisorByIdAction;
use App\Actions\GetAdvisorsAndLanguagesAction;
use App\Actions\GetSelectLanguagesAction;
use App\Actions\StoreAdvisorAction;
use App\Actions\UpdateAdvisorAction;
use App\DTO\AdvisorData;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAdvisorRequest;
use App\Http\Requests\StoreAdvisorRequest;
use App\Http\Requests\UpdateAdvisorRequest;
use App\Models\Advisor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

final class AdvisorsController extends Controller
{
    use MediaUploadingTrait;

    public function index(
        GetAdvisorsAndLanguagesAction $action
    ): Factory|View|Application {
        $this->checkAccess('advisor_access');

        $viewModel = $action();

        return view('admin.advisors.index', [
            'advisors' => $viewModel->advisors(),
            'languages' => $viewModel->languages()
        ]);
    }

    public function create(
        GetSelectLanguagesAction $action
    ): Factory|View|Application {
        $this->checkAccess('advisor_create');

        return view('admin.advisors.create', [
            'languages' => $action()
        ]);
    }

    public function store(
        StoreAdvisorRequest $request,
        StoreAdvisorAction $action
    ): \Illuminate\Http\RedirectResponse {
        $action(AdvisorData::fromRequest($request));

        return redirect()->route('admin.advisors.index');
    }

    public function edit(
        int $advisor,
        GetAdvisorByIdAction $action,
        GetSelectLanguagesAction $languagesAction
    ): Factory|View|Application {
        $this->checkAccess('advisor_edit');

        return view('admin.advisors.edit', [
            'languages' => $languagesAction(),
            'advisor' => $action($advisor)
        ]);
    }

    public function update(
        UpdateAdvisorRequest $request,
        int $advisor,
        UpdateAdvisorAction $action
    ): \Illuminate\Http\RedirectResponse {
        $data = AdvisorData::fromRequest($request);
        $data->id = $advisor;
        $action($data);

        return redirect()->route('admin.advisors.index');
    }

    public function show(
        int $advisor,
        GetAdvisorByIdAction $action
    ): Factory|View|Application {
        $this->checkAccess('advisor_show');

        return view('admin.advisors.show', [
            'advisor' => $action($advisor)
        ]);
    }

    public function destroy(
        int $advisor,
        DeleteAdvisorAction $action
    ): \Illuminate\Http\RedirectResponse {
        $this->checkAccess('advisor_delete');

        $action($advisor);

        return back();
    }

    public function massDestroy(
        MassDestroyAdvisorRequest $request,
        DeleteAdvisorAction $action
    ): \Illuminate\Http\Response|Application|ResponseFactory {
        $ids = request('ids');
        foreach ($ids as $id) {
            $action($id);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->checkAccess('advisor_create');

        $model         = new Advisor();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
