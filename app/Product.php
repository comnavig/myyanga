<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public function listing()
    {
		return $this->belongsTo('App\Listing');
	}
	
	public function picture()
    {
		return $this->hasMany('App\ProductPicture');
	}
	
    public function location()
    {
		return $this->belongsTo('App\Location');
	}

    public function category()
    {
		return $this->belongsTo('App\Category');
	}

    public function featuredCategory()
    {
		return $this->belongsTo('App\FeaturedCategory', 'featured');
	}

    public function shipment()
    {
		return $this->hasOne('App\ProductShipment');
	}

    public function favourite()
    {
		return $this->hasMany('App\ProductFavourite');
	}
	
    public function sold()
    {
		return $this->hasMany('App\ProductSold');
	}
	
    public function review()
    {
		return $this->hasMany('App\ProductReview');
	}
	
	public function show_days($this_date)
	{
		//~ $this_date = createdate("Y-m-d", $date);
		$today = date("Y-m-d");
		
		$origin = date_create($this_date);
		$target = date_create($today);
		
		$interval = $origin->diff($target);
		return $interval->format('%a');
	}
	
    public function user()
    {
		return $this->belongsTo('App\User');
	}
}
