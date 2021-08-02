<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    
    public function parent()
    {
		return $this->belongsTo('App\ParentCategory', 'parent_id');
	}
    
    public function subcategories()
    {
		return $this->hasMany('App\Subcategory', 'parent_id');
	}
	
	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
