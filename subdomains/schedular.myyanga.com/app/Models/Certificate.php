<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{

    protected $fillable = ['cohort_id', 'student_name', 'completion_date'];
    
    protected $primaryKey = 'id';

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    // use HasFactory;
}
