<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Student;

class Appointment extends Model
{
    use HasFactory;

    protected $appends = ['length'];

    public function teacher()
    {
    	return $this->belongsTo(Teacher::class);
    }

    public function student()
    {
    	return $this->belongsTo(Student::class);
    }

    public function getLengthAttribute()
    {
    	return $this->to;
    }
}
