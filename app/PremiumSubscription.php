<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PremiumSubscription extends Model
{
    //
    public function user()
    {
		return $this->belongsTo('App\User');
	}
	
	public function daysLeft($expiry)
	{
		$date1=date_create("now");
		$date2=date_create($expiry);
		
		$diff=date_diff($date1,$date2);
		
		return $diff->format("%a");
	}
	
	public function daysOver($expiry)
	{
		$date1=date_create("now");
		$date2=date_create($expiry);
		
		if($date1 > $date2)
		{
			return true;
		}
		
		return false;
	}
	
}
