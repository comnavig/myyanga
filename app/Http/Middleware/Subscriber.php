<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\PremiumSubscription;

class Subscriber
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
		//~ $user = User::find($user_id);
		$active_subscription = PremiumSubscription::where([["user_id", "=",$user_id],["status","=","PAID"]])->get()->last();
		
		if (empty($active_subscription))
		{
			return redirect()->route('user.premium.subscriptions');
		}
		else
		{
			$date1=date_create("now");
			$date2=date_create($active_subscription->expiry);
		
			if($date1 > $date2)
			{
				return redirect()->route('user.premium.subscriptions');
			}
			else
			{
				return $next($request);
			}
		}
		
    }
}
