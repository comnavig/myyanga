<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroomTipCategory extends Model
{
    //
    public function groomtips()
	{
		return $this->hasMany('App\GroomTips', 'category_id');
	}
	
    public function user()
	{
		return $this->belongsTo('App\User');
	}
}
