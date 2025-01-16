<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckStorePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission)
    {
        // $user = Auth::user();
        // $storeId = $request->route('store')->id; // Example route binding

        // $role = $user->storeUserRoles()
        //     ->where('store_id', $storeId)
        //     ->first();

        // if (!$role || !$role->permissions->contains('name', $permission)) {
        //     return response()->json(['message' => 'Permission denied'], 403);
        // }

        return $next($request);
    }
}
