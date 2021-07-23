<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Lesson;
use MacsiDigital\Zoom\Facades\Zoom;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'lesson_id',
        'type',
        'start',
        'end',
	    'active',
        'student_approved',
        'teacher_approved',
    ];

    protected $appends = ['meeting_url'];

    public function teacher()
    {
    	return $this->belongsTo(Teacher::class);
    }

    public function student()
    {
    	return $this->belongsTo(Student::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function getMeetingUrlAttribute()
    {
        return $this->meeting_id;
    }
}
