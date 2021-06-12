<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('v1/token', \App\Http\Controllers\Auth\CreateTokenController::class);

Route::post('upload', \App\Http\Controllers\Api\V1\Admin\UploadController::class)
    ->name('fileUpload');

Route::group(['prefix' => 'v1', 'as' => 'api.', 'middleware' => ['auth:sanctum']], function () {

    // Languages
    Route::apiResource('languages', \App\Http\Controllers\Api\V1\Admin\LanguagesApiController::class);

    // Advisors
    Route::post('advisors/media', [
        \App\Http\Controllers\Api\V1\Admin\AdvisorsApiController::class,
        'storeMedia'
    ])->name('advisors.storeMedia');
    Route::apiResource('advisors', \App\Http\Controllers\Api\V1\Admin\AdvisorsApiController::class);
});
