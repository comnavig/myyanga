<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    
	public function areas()
    {
		return $this->hasMany('App\Area', 'parent_id');
	}
	
	public function user()
	{
		return $this->belongsTo('App\User');
	}
	
	public function state()
	{
		return $this->belongsTo('App\State', 'parent_id');
	}
}
