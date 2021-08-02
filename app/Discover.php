<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discover extends Model
{
    //
	public function picture()
    {
		return $this->hasMany('App\DiscoverPicture');
	}
	
	public function discover_category()
    {
		return $this->belongsTo('App\DiscoverCategory');
	}

    public function user()
    {
		return $this->belongsTo('App\User');
	}
}
