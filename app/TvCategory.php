<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TvCategory extends Model
{
    //
	public function tvs()
	{
		return $this->hasMany('App\Tv');
	}
	
    public function user()
	{
		return $this->belongsTo('App\User');
	}
}
