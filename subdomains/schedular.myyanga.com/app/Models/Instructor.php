<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable = ['name', 'photo', 'linkedin_url', 'bio'];

    protected $primaryKey = 'id';

    use HasFactory;

    public function cohorts()
    {
        return $this->hasMany(Cohort::class);
    }
}
