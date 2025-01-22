<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateOnceWithBasicAuth
{
    public function handle($request, Closure $next)
    {
        return Auth::onceBasic() ?: $next($request);
    }
}
