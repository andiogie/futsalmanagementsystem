<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DemoRole2
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!session('demo_login')) {
            return redirect('/login');
        }

        if (session('demo_user.roles') !== $role) {
            abort(403);
        }

        return $next($request);
    }
}
