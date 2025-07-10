<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordIsChanged
{
    /**
     * The names of the routes that are allowed to be accessed.
     *
     * @var array<int, string>
     */
    protected const ALLOWED_ROUTES = [
        'change-password',
        'logout',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->first_login) {
            if (!in_array($request->route()->getName(), self::ALLOWED_ROUTES)) {
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
