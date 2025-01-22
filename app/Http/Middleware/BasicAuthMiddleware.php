<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class BasicAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve the Authorization header
        $authorizationHeader = $request->headers->get('Authorization');

        // If no header or incorrect format, send a 401 response
        if (!$authorizationHeader || !preg_match('/^Basic (.+)$/i', $authorizationHeader, $matches)) {
            return response('Unauthorized', 401)
                ->header('WWW-Authenticate', 'Basic realm="Restricted Area"');
        }

        // Decode the credentials (username:password) from base64
        $credentials = base64_decode($matches[1]);
        [$username, $password] = explode(':', $credentials, 2);

        // Find the user in the database by username
        $user = User::where('name', $username)->first();

        // Check if user exists and the password is correct
        if (!$user || !password_verify($password, $user->password)) {
            return response('Unauthorized', 401)
                ->header('WWW-Authenticate', 'Basic realm="Restricted Area"');
        }

        // Optionally, set authenticated user in the request (useful for later access in the controller)
        auth()->login($user);

        return $next($request);  // Proceed with the next request
    }
}
