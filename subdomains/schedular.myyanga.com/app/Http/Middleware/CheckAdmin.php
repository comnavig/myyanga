<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve the bearer token from the request headers
        $bearerToken = $request->bearerToken();

        // Find the user associated with the bearer token
        $user = User::where('api_token', $bearerToken)->first();

        if ($user && $user->user_role === 1) {
            $request->merge(['user' => $user]);
            return $next($request);
        }

        // User is not an admin, return a 403 Forbidden response
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
