<?php

namespace App\Services;

use Illuminate\Http\Request;

class AuthService
{
    public function attempt(Request $request, array $credentials): bool
    {
        $allowedEmail = config('demo.login.email');
        $allowedPassword = config('demo.login.password');

        if ($credentials['email'] === $allowedEmail && $credentials['password'] === $allowedPassword) {
            $request->session()->put('user', [
                'name' => config('demo.login.name'),
                'email' => $allowedEmail,
            ]);
            return true;
        }

        return false;
    }

    public function logout(Request $request): void
    {
        $request->session()->forget('user');
    }
}
