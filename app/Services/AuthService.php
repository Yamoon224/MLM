<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Login user by email or phone
     *
     * @param string $login
     * @param string $password
     * @return User
     *
     * @throws ValidationException
     */
    public function login(string $login, string $password): User
    {
        // Cherche l'utilisateur par email ou phone
        $user = User::where('email', $login)
                    ->orWhere('phone', $login)
                    ->first();

        // Vérifie credentials
        if (!$user || !Auth::attempt(['email' => $user->email, 'password' => $password])) {
            throw ValidationException::withMessages([
                'login' => ['Invalid credentials.'],
            ]);
        }

        return $user;
    }

    /**
     * Crée un token API pour l'utilisateur connecté
     */
    public function createToken(User $user, string $tokenName = 'api_token'): string
    {
        return $user->createToken($tokenName)->plainTextToken;
    }
}