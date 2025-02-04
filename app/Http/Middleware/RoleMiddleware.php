<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role, $guard = null)
    {
        
        $authGuard = app('auth')->guard($guard);


        if ($authGuard->guest()) {
            return response()->json([
                'error' => 'Authentication required',
                'message' => 'You must be logged in to access this resource'
            ], 401);
        }

        $roles = is_array($role)
            ? $role
            : explode('|', $role);


        if (! $authGuard->user()->hasAnyRole($roles)) {
            return response()->json([
                'error' => 'Unauthorized access',
                'message' => 'You do not have the required roles to access this resource',
                'required_roles' => $roles
            ], 403);
        }
            
        
        return $next($request);
    }
}
