<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permissionName): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Unauthorized: User not logged in.');
        }

        $role = $user->role;

        if (!$role) {
            abort(403, 'Unauthorized: No role assigned to user.');
        }

        $hasPermission = $role->permissions()->where('name', $permissionName)->exists();

        if (!$hasPermission) {
            abort(403, 'Permission denied.');
        }

        return $next($request);
    }
}
