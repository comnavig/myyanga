<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CohortLocation extends Model
{
    protected $fillable = ['cohort_id', 'location_id', 'zoom_url', 'start_date', 'end_date'];

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    use HasFactory;
}