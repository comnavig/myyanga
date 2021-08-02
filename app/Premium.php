<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Premium extends Model
{
    //
    public function picture()
    {
		return $this->hasMany('App\PremiumPicture');
	}
	
	public function premium_category()
    {
		return $this->belongsTo('App\PremiumCategory');
	}

    public function user()
    {
		return $this->belongsTo('App\User');
	}
}
