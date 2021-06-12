<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPermissionRequest;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

final class PermissionsController extends Controller
{
    public function index(): Factory|View|Application
    {
        $this->checkAccess('permission_access');

        $permissions = Permission::all();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create(): Factory|View|Application
    {
        $this->checkAccess('permission_create');

        return view('admin.permissions.create');
    }

    public function store(StorePermissionRequest $request): \Illuminate\Http\RedirectResponse
    {
        $permission = Permission::create($request->all());

        return redirect()->route('admin.permissions.index');
    }

    public function edit(Permission $permission): Factory|View|Application
    {
        $this->checkAccess('permission_edit');

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(
        UpdatePermissionRequest $request,
        Permission $permission
    ): \Illuminate\Http\RedirectResponse {
        $permission->update($request->all());

        return redirect()->route('admin.permissions.index');
    }

    public function show(Permission $permission): Factory|View|Application
    {
        $this->checkAccess('permission_show');

        return view('admin.permissions.show', compact('permission'));
    }

    public function destroy(Permission $permission): \Illuminate\Http\RedirectResponse
    {
        $this->checkAccess('permission_delete');

        $permission->delete();

        return back();
    }

    public function massDestroy(
        MassDestroyPermissionRequest $request
    ): \Illuminate\Http\Response|Application|ResponseFactory {
        Permission::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
