<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isAdminRole()) {
            return redirect('/')->with('error', 'Access denied. Admins only.');
        }

        return $next($request);
    }
}
