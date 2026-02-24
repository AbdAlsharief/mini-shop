<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isMerchant()) {
            return redirect('/')->with('error', 'Access denied. Merchants only.');
        }

        return $next($request);
    }
}
