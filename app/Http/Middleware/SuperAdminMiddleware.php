<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->hasRole('super-admin')) {
            return response()->json([
                'message' => 'Bu işlemi yalnızca süper admin yapabilir.'
            ], 403);
        }

        return $next($request);
    }
} 