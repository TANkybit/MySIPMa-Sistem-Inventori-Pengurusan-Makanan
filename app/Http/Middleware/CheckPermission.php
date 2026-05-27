<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $feature)
    {
        if (!Auth::check() || !Auth::user()->hasPermission($feature)) {
            abort(403, 'Anda tidak mempunyai kebenaran untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
