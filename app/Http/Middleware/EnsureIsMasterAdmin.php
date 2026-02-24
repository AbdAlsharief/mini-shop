<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsMasterAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isMasterAdmin()) {
            return redirect('/')->with('error', 'Access denied. Master admin only.');
        }

        return $next($request);
    }
}
