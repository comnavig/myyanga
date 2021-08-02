<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroomTips extends Model
{
    //
    public function picture()
    {
		return $this->hasMany('App\GroomTipsPicture');
	}
	
	public function category()
    {
		return $this->belongsTo('App\GroomTipCategory');
	}

    public function user()
    {
		return $this->belongsTo('App\User');
	}
}
