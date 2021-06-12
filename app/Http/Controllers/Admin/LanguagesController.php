<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\GetAllLanguagesAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLanguageRequest;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Models\Language;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

final class LanguagesController extends Controller
{
    public function index(GetAllLanguagesAction $action): Factory|View|Application
    {
        $this->checkAccess('language_access');

        return view('admin.languages.index', [
            'languages' => $action()
        ]);
    }

    public function create(): Factory|View|Application
    {
        $this->checkAccess('language_create');

        return view('admin.languages.create');
    }

    public function store(StoreLanguageRequest $request): \Illuminate\Http\RedirectResponse
    {
        $language = Language::create($request->all());

        return redirect()->route('admin.languages.index');
    }

    public function edit(Language $language): Factory|View|Application
    {
        $this->checkAccess('language_edit');

        return view('admin.languages.edit', compact('language'));
    }

    public function update(
        UpdateLanguageRequest $request,
        Language $language
    ): \Illuminate\Http\RedirectResponse {
        $language->update($request->all());

        return redirect()->route('admin.languages.index');
    }

    public function show(Language $language): Factory|View|Application
    {
        $this->checkAccess('language_show');

        $language->load('languageAdvisors');

        return view('admin.languages.show', compact('language'));
    }

    public function destroy(Language $language): \Illuminate\Http\RedirectResponse
    {
        $this->checkAccess('language_delete');

        $language->delete();

        return back();
    }

    public function massDestroy(
        MassDestroyLanguageRequest $request
    ): \Illuminate\Http\Response|Application|ResponseFactory {
        Language::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
