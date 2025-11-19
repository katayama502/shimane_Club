<?php

namespace App\Http\Controllers;

use App\Services\CompanyRepository;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(private CompanyRepository $companies)
    {
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'support_menu' => ['required', 'string'],
        ]);

        $this->companies->store($validated);

        return response()->json([
            'message' => '企業情報を登録しました。担当者からの連絡をお待ちください。'
        ], 201);
    }
}
