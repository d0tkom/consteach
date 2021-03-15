<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Student;
use MacsiDigital\Zoom\Facades\Zoom;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'type',
        'start',
        'end',
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

    public function getMeetingUrlAttribute()
    {
        return Zoom::meeting()->find($this->meeting_id)->join_url;
    }
}
