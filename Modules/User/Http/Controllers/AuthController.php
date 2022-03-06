<?php

namespace UserModule\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use UserModule\Http\Requests\AuthenticateRequest;
use UserModule\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function authenticate(AuthenticateRequest $request)
    {
        $userToken = $this->authService->authenticate(
            $request->input('email'),
            $request->input('password')
        );

        if (!$userToken) {
            return $this->generateErrorResponse(__('auth.failed'), Response::HTTP_UNAUTHORIZED);
        }

        return $this->generateSuccessResponse([
            'token' => $userToken,
        ]);
    }
}
