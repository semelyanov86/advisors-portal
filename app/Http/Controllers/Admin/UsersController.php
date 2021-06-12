<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\GetSelectRolesAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

final class UsersController extends Controller
{
    public function index(): Factory|View|Application
    {
        $this->checkAccess('user_access');

        $users = User::with(['roles'])->get();

        return view('admin.users.index', compact('users'));
    }

    public function create(GetSelectRolesAction $action): Factory|View|Application
    {
        $this->checkAccess('user_create');

        return view('admin.users.create', [
            'roles' => $action()
        ]);
    }

    public function store(StoreUserRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user, GetSelectRolesAction $rolesAction): Factory|View|Application
    {
        $this->checkAccess('user_edit');

        $roles = $rolesAction();

        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function show(User $user): Factory|View|Application
    {
        $this->checkAccess('user_show');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user): \Illuminate\Http\RedirectResponse
    {
        $this->checkAccess('user_delete');

        $user->delete();

        return back();
    }

    public function massDestroy(
        MassDestroyUserRequest $request
    ): \Illuminate\Http\Response|Application|ResponseFactory {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
