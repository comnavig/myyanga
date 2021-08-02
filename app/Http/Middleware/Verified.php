<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class Verified
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
		$user = Auth::user();
		
		if ( empty($user->email_verified_at) )
		{
			//~ return redirect()->route('not.verified');
			return redirect('/email/verify/');
		}
		
        return $next($request);
    }
}
