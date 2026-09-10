<?php

namespace App\Modules\Auth\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Application\Contracts\LoginWithPassword;
use App\Modules\Auth\Presentation\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private LoginWithPassword $loginWithPassword,
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = $this->loginWithPassword->execute(
            email: $data['email'],
            password: $data['password'],
            deviceUuid: $data['device_uuid'],
        );

        return response()->json(
            $result,
            200,
        );
    }
}
