<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $auth)
    {
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($this->auth->attempt($request, $validated)) {
            return response()->json([
                'message' => 'ログインしました。',
                'user' => $request->session()->get('user'),
            ]);
        }

        return response()->json([
            'message' => 'メールアドレスまたはパスワードが違います。'
        ], 422);
    }

    public function logout(Request $request)
    {
        $this->auth->logout($request);

        return response()->json(['message' => 'ログアウトしました。']);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->session()->get('user')
        ]);
    }
}
