<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    //
    
    public function main()
    {
		return $this->belongsTo('App\Listing', 'parent_id');
	}
    
    public function product()
    {
		return $this->hasMany('App\Product');
	}
	
    public function picture()
    {
		return $this->hasMany('App\Picture');
	}
	
    public function plan()
    {
		return $this->belongsTo('App\Plan');
	}

    public function location()
    {
		return $this->belongsTo('App\Location');
	}

    public function category()
    {
		return $this->hasMany('App\ListingCategory');
	}
	
    public function email()
    {
		return $this->hasMany('App\ListingEmail');
	}
	
    public function phone()
    {
		return $this->hasMany('App\ListingPhone');
	}
	
    public function url()
    {
		return $this->hasMany('App\ListingUrl');
	}
	
    public function user()
    {
		return $this->belongsTo('App\User');
	}
}
