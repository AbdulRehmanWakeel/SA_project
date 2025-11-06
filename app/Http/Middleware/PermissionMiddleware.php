<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permissionName): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Unauthorized: User not logged in.');
        }

        $group = DB::table('user_group')
            ->where('user_id', $user->id)
            ->first();

        if (!$group) {
            abort(403, 'Unauthorized: No group assigned to user.');
        }

        $hasPermission = DB::table('group_permission')
            ->join('permissions', 'group_permission.permission_id', '=', 'permissions.id')
            ->where('group_permission.group_id', $group->group_id)
            ->where('permissions.name', $permissionName)
            ->exists();

        if (!$hasPermission) {
            abort(403, 'Permission denied.');
        }

        return $next($request);
    }
}
