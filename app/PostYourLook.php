<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostYourLook extends Model
{
    //
    public function entries()
    {
		return $this->hasMany('App\UserPostYourLook');
	}
	
    public function expired()
    {
		$today = date_create('now');
		$expiry_date = date_create($this->expired_at);
		
		$expired = ($expiry_date > $today ? true : false);
		
		return $expired;
	}
	
    public function ordinal($number)
    {
		$ends = array('th','st','nd','rd','th','th','th','th','th','th');
		
		if ((($number % 100) >= 11) && (($number%100) <= 13))
		{
			return $number. 'th';
		}
		else
		{
			return $number. $ends[$number % 10];
		}
	}
	
    public function status()
    {
		$today = date_create('now');
		$expiry_date = date_create($this->expired_at);
		
		$status = ($expiry_date > $today ? "Ongoing" : "Closed");
		
		return $status;
	}
}
