<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'duration', 'price', 'featured_image', 'created_by'];

    protected $primaryKey = 'id';

    public function cohorts()
    {
        return $this->hasMany(Cohort::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    // use HasFactory;
}
