<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('kasir')->check()) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }

        return $next($request);
    }
}