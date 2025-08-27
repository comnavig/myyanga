<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PremiumCategory extends Model
{
    //
    public function premia()
	{
		return $this->hasMany('App\Premium');
	}
	
    public function user()
	{
		return $this->belongsTo('App\User');
	}
}
