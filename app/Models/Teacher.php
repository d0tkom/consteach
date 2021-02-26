<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Appointment;

class Teacher extends Model
{
    use HasFactory;

    protected $appends = ['appointment_count', 'student_count'];

    protected $casts = [
        'teaching_languages' => 'array',
        'about_me' => 'array',
    ];

    protected $fillable = [
    	'user_id',
    	'about_me',
        'country',
        'teaching_languages',
        'video_url',
        'one_hour_price',
        'five_hour_price',
        'ten_hour_price',
	];

    public function lessons()
    {
    	return $this->hasMany(Lesson::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getAppointmentCountAttribute()
    {
    	$appointments = Appointment::where('teacher_id', $this->id)->where('student_approved', 1)->where('teacher_approved', 1)->get();
    	return count($appointments);
    }

    public function getStudentCountAttribute()
    {
    	$lessons = Lesson::where('teacher_id', $this->id)->get();
    	return count($lessons);
    }
}