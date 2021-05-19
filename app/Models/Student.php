<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Appointment;

class Student extends Model
{
    use HasFactory;

    protected $appends = ['trial_available', 'booked_lessons', 'available_lessons', 'finished_lessons'];

    protected $fillable = [
    	'user_id',
    	'wanted_language',
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getTrialAvailableAttribute()
    {
        return $this->appointments()->where('type', 'try')->count() > 0 ? false : true;
    }

    public function getBookedLessonsAttribute()
    {
        $lessons = Lesson::where('student_id', $this->id)->where('status', 1)->get();
        return count($lessons);
    }

    public function getAvailableLessonsAttribute()
    {
        $lessons = Lesson::where('student_id', $this->id)->where('status', 0)->get();
        return count($lessons);
    }

    public function getFinishedLessonsAttribute()
    {
        $lessons = Lesson::where('student_id', $this->id)->where('status', 2)->get();
        return count($lessons);
    }
}