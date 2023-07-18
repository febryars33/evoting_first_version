<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function candidate()
    {
        return $this->hasMany(Candidate::class);
    }

    public function study_program()
    {
        return $this->belongsTo(Study_Program::class);
    }
}
