<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeaturedCategory extends Model
{
    //
    public function featured()
	{
		return $this->hasMany('App\FeaturedProduct');
	}
	
    public function user()
	{
		return $this->belongsTo('App\User');
	}
}
