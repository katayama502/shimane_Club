<?php

namespace App\Http\Middleware;

use App\Services\ClubRepository;
use Closure;
use Illuminate\Http\Request;

class ShareViewData
{
    public function __construct(private ClubRepository $clubs)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        view()->share('authUser', $request->session()->get('user'));
        view()->share('initialClubs', $this->clubs->all());

        return $next($request);
    }
}
