<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    
    public function address()
    {
		return $this->belongsTo('App\Address');
	}
	
	public function sold()
	{
		return $this->hasMany('App\ProductSold');
	}
	
	public function user()
	{
		return $this->belongsTo('App\User');
	}
	
}
