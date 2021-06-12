<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth']], function () {
        Route::get('/', [
        \App\Http\Controllers\Admin\HomeController::class,
        'index'
        ])->name('home');
    // Permissions
        Route::delete('permissions/destroy', [
        \App\Http\Controllers\Admin\PermissionsController::class,
        'massDestroy'
        ])->name('permissions.massDestroy');
        Route::resource('permissions', \App\Http\Controllers\Admin\PermissionsController::class);

    // Roles
        Route::delete('roles/destroy', [
            \App\Http\Controllers\Admin\RolesController::class,
            'massDestroy'
        ])->name('roles.massDestroy');
        Route::resource('roles', \App\Http\Controllers\Admin\RolesController::class);

    // Users
        Route::delete('users/destroy', [
            \App\Http\Controllers\Admin\UsersController::class,
            'massDestroy'
        ])->name('users.massDestroy');
        Route::resource('users', \App\Http\Controllers\Admin\UsersController::class);

    // Languages
        Route::delete('languages/destroy', [
            \App\Http\Controllers\Admin\LanguagesController::class,
            'massDestroy'
        ])->name('languages.massDestroy');
        Route::resource('languages', \App\Http\Controllers\Admin\LanguagesController::class);

    // Advisors
        Route::delete('advisors/destroy', [
            \App\Http\Controllers\Admin\AdvisorsController::class,
            'massDestroy'
        ])->name('advisors.massDestroy');
        Route::post('advisors/media', [
            \App\Http\Controllers\Admin\AdvisorsController::class,
            'storeMedia'
        ])->name('advisors.storeMedia');
        Route::post('advisors/ckmedia', [
            \App\Http\Controllers\Admin\AdvisorsController::class,
            'storeCKEditorImages'
        ])->name('advisors.storeCKEditorImages');
        Route::resource('advisors', \App\Http\Controllers\Admin\AdvisorsController::class);
    });
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', [
            \App\Http\Controllers\Auth\ChangePasswordController::class,
            'edit'
        ])->name('password.edit');
        Route::post('password', [
            \App\Http\Controllers\Auth\ChangePasswordController::class,
            'update'
        ])->name('password.update');
        Route::post('profile', [
            \App\Http\Controllers\Auth\ChangePasswordController::class,
            'updateProfile'
        ])->name('password.updateProfile');
        Route::post('profile/destroy', [
            \App\Http\Controllers\Auth\ChangePasswordController::class,
            'destroy'
        ])->name('password.destroyProfile');
    }
});
