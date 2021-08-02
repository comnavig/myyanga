<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function picture()
    {
		return $this->hasMany('App\PostPicture');
	}
	
	public function post_category()
    {
		return $this->belongsTo('App\PostCategory');
	}

    public function user()
    {
		return $this->belongsTo('App\User');
	}
}
