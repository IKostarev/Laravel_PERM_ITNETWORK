<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends ApiController
{
    /**
     * Авторизация
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])) {
            /** @var User $user */
            $user = auth()->user();

            $user->tokens()->delete();

            return $this->respondWithSuccess([
                'token' => $user->createToken('app')->plainTextToken
            ]);
        }

        return $this->respondWithError("Неверный логин или пароль", [], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function logout(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $user->tokens()->delete();

        return $this->respondWithSuccess();
    }
}
