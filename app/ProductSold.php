<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSold extends Model
{
    //
    
    public function product()
	{
		return $this->belongsTo('App\Product');
	}
	
    public function order()
	{
		return $this->belongsTo('App\Order');
	}
	
	public function delivery_note()
	{
		return $this->hasMany('App\DeliveryNote');
	}
}
