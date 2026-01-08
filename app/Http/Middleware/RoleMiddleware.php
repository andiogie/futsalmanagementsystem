<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{

    public function handle($request, Closure $next, ...$roles)
    {

        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        if (!in_array($user->roles, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
