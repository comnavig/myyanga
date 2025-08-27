<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'address', 'city', 'country'];

    protected $primaryKey = 'id';

    public function cohortLocations()
    {
        return $this->belongsToMany(CohortLocation::class);
    }

    // use HasFactory;
}
