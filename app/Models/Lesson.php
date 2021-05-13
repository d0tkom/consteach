<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Appointment;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
    	'student_id',
    	'teacher_id'
    ];

    public function teacher()
    {
    	return $this->belongsTo(Teacher::class);
    }

    public function student()
    {
    	return $this->belongsTo(Student::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}
