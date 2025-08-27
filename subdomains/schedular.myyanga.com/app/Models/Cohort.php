<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
    protected $fillable = ['course_id', 'start_date', 'end_date', 'cohort_location_id', 'instructor_id', 'created_by'];

    protected $primaryKey = 'id';

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function cohortLocation()
    {
        return $this->hasMany(CohortLocation::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // use HasFactory;
}
