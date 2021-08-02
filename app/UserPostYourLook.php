<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostYourLook extends Model
{
    //
    public function user()
    {
		return $this->belongsTo('App\User');
	}
	
	public function votes()
	{
		return $this->hasMany('App\PostYourLookVote');
	}
	
	public function pyl()
	{
		return $this->belongsTo('App\PostYourLook', 'post_your_look_id');
	}
}
