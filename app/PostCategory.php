<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    //
     public function posts()
	{
		return $this->hasMany('App\Post');
	}
	
    public function user()
	{
		return $this->belongsTo('App\User');
	}
}
