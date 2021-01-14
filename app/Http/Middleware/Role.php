<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {
        $user = Auth::guard()->user();
        $user->roles = $user->roles()->get();
        $userRoles = $user->roles()->pluck('role_name')->toArray();
        foreach($roles as $role) {
            if (in_array($role, $userRoles))
            {
                return $next($request);
            }
        }
        return response()->json([
            "error" => "Unauthorized User."
        ], 401);
    }
}
