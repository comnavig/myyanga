<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscoverCategory extends Model
{
    //
     public function discovers()
	{
		return $this->hasMany('App\Discover');
	}
	
    public function user()
	{
		return $this->belongsTo('App\User');
	}
}
