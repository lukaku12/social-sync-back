<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create($validated);

        event(new Registered($user));

        return response()->json(['message' => 'User successfully registered!']);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (!User::where('email', $validated['email'])->exists()) {
            return response()->json(['errors' => [
                'email' => 'Email address is not correct',
            ]], 401);
        }

        if (!auth()->attempt($validated)) {
            return response()->json(['errors' => [
                'password' => 'Password is not correct']
            ], 401);
        }

        $token = auth()->user()->createToken(auth()->user()->name . '-AuthToken')->plainTextToken;

        return response()->json(['access_token' => $token]);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json(["message" => "User successfully logged out!"]);
    }
}
