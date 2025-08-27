<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tv extends Model
{
    //
    public function tv_category()
    {
		return $this->belongsTo('App\TvCategory');
	}

    public function user()
    {
		return $this->belongsTo('App\User');
	}
}
