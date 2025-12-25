<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        $roleValue = $user?->role ?? $user?->role()->value('role_name');

        if (!$user || !$roleValue || !in_array($roleValue, $roles)) {
            return response()->json([
                'message' => 'Access denied: insufficient permissions'
            ], 403);
        }

        return $next($request);
    }
}
