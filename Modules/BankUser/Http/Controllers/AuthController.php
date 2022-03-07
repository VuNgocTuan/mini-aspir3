<?php

namespace BankUserModule\Http\Controllers;

use App\Http\Controllers\Controller;
use BankUserModule\Http\Requests\AuthenticateRequest;
use BankUserModule\Services\AuthService;
use Illuminate\Http\Response;

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
