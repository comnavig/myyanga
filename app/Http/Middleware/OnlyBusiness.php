<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class OnlyBusiness
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_id = Auth::id();
		$user = User::find($user_id);
		
		if ($user->type !== "BUSINESS")
		{
			return redirect()->route('login');
		}
		
        return $next($request);
    }
}
