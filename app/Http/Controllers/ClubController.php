<?php

namespace App\Http\Controllers;

use App\Services\ClubRepository;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function __construct(private ClubRepository $clubs)
    {
    }

    public function index()
    {
        return response()->json([
            'data' => $this->clubs->all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'area' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'needs' => ['required', 'string'],
        ]);

        $club = $this->clubs->store($validated);

        return response()->json([
            'message' => 'クラブ情報を登録しました。',
            'club' => $club,
        ], 201);
    }

    public function apply(Request $request, int $clubId)
    {
        if (!$request->session()->has('user')) {
            return response()->json([
                'message' => 'マッチング申請を行うにはログインが必要です。'
            ], 401);
        }

        $clubs = $this->clubs->all();
        $target = null;
        foreach ($clubs as $club) {
            if ((int) $club['id'] === (int) $clubId) {
                $target = $club;
                break;
            }
        }

        if (!$target) {
            return response()->json(['message' => '対象の部活動が見つかりませんでした。'], 404);
        }

        return response()->json([
            'message' => "『{$target['name']}』へマッチング申請を送信しました！",
        ]);
    }
}
