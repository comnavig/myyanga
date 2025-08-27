<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;


class GetUserFromToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bearerToken = $request->bearerToken();

        // Find the user associated with the bearer token
        $user = User::where('api_token', $bearerToken)->first();

        // Check if user was found
        if ($user) {
            // Attach the user to the request for further use
            $request->merge(['user' => $user]);
            return $next($request);

        }

        // User is not an admin, return a 403 Forbidden response
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
