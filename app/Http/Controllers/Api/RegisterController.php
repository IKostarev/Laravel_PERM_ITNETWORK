<?php

namespace App\Http\Controllers\Api;

use App\Events\UserCreatedEvent;
use App\Jobs\UserCreatedJob;
use App\Mail\UserCreated;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends ApiController
{
    /**
     * Регистрация
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $validated['password'] = \Hash::make($validated['password']);
        $user = User::create($validated);

        UserCreatedEvent::dispatch($user);

        return $this->respondWithSuccess([
            'token' => $user->createToken('app')->plainTextToken
        ]);
    }
}
