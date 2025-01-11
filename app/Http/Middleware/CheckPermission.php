<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        /*
        if (!$user->hasPermission($module, $action)) {
            abort(403, 'Bu işlem için yetkiniz bulunmamaktadır.');
        }
            */

        return $next($request);
    }
}
