<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    //
    protected $table = 'categories';
     
    public function user()
    {
		return $this->belongsTo('App\User');
	}
	
    public function product()
    {
		return $this->hasMany('App\Product','category_id');
	}
}
