<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\CreateTokenRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class CreateTokenController extends \App\Http\Controllers\Controller
{
    public function __invoke(CreateTokenRequest $request): \Illuminate\Http\JsonResponse
    {
        $result = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if (!$result) {
            abort(403, 'Login or password does not math');
        }

        $token = $request->user()->createToken($request->device_name);

        return \Response::json(['token' => $token->plainTextToken]);
    }
}
