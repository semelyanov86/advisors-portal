<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;

final class RolesController extends Controller
{
    public function index(): Factory|View|Application
    {
        $this->checkAccess('role_access');

        $roles = Role::with(['permissions'])->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create(): Factory|View|Application
    {
        $this->checkAccess('role_create');

        $permissions = Permission::all()->pluck('title', 'id');

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request): \Illuminate\Http\RedirectResponse
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role): Factory|View|Application
    {
        $this->checkAccess('role_edit');

        $permissions = Permission::all()->pluck('title', 'id');

        $role->load('permissions');

        return view('admin.roles.edit', compact('permissions', 'role'));
    }

    public function update(UpdateRoleRequest $request, Role $role): \Illuminate\Http\RedirectResponse
    {
        $role->update($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.roles.index');
    }

    public function show(Role $role): Factory|View|Application
    {
        $this->checkAccess('role_show');

        $role->load('permissions');

        return view('admin.roles.show', compact('role'));
    }

    public function destroy(Role $role): \Illuminate\Http\RedirectResponse
    {
        $this->checkAccess('role_delete');

        $role->delete();

        return back();
    }

    public function massDestroy(MassDestroyRoleRequest $request): \Illuminate\Http\Response|Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        Role::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
