<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Usage in routes:
     *   ->middleware('role:merchant')        — merchant + master_admin
     *   ->middleware('role:admin')           — admin + master_admin
     *   ->middleware('role:master_admin')    — master_admin only
     *   ->middleware('role:admin,merchant')  — either (OR logic)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->hasRole($roles)) {
            return redirect('/')->with('error', 'Access denied. You do not have permission.');
        }

        return $next($request);
    }
}
