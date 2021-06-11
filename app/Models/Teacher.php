<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Availability;

class Teacher extends Model
{
    use HasFactory;

    protected $appends = ['appointment_count', 'student_count', 'available_payout', 'booked_lessons', 'available_lessons', 'finished_lessons'];

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
        'twenty_hour_price',
        'complete',
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

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    public function getAppointmentCountAttribute()
    {
    	$appointments = Appointment::where('teacher_id', $this->id)->where('student_approved', 1)->where('teacher_approved', 1)->get();
    	return count($appointments);
    }

    public function getAvailablePayoutAttribute()
    {
        $lessons = Lesson::where('teacher_id', $this->id)->where('payout_available', true)->get();

        $total = 0;

        foreach ($lessons as $lesson) {
            $total += $lesson->price;
        }

        return $total/100;
    }

    public function getStudentCountAttribute()
    {
    	$lessons = Lesson::where('teacher_id', $this->id)->get();
    	return count($lessons);
    }

    public static function getAllLanguages() 
    {
        $teachersAvailableLanguages = Teacher::select(['teaching_languages'])
            ->where('complete', true)
            ->where('validated', true)
            ->get();

        $availableLanguages = [];
        foreach($teachersAvailableLanguages as $teacherAvailableLanguages) {
            if (!is_array($teacherAvailableLanguages->teaching_languages)) {
                continue;
            }

            foreach($teacherAvailableLanguages->teaching_languages as $teacherAvailableLanguage) {
                if (!in_array($teacherAvailableLanguage['language'], $availableLanguages)) {
                    $availableLanguages[] = $teacherAvailableLanguage['language'];
                }
            }
        }

        return $availableLanguages;
    }

    public function getBookedLessonsAttribute()
    {
        $lessons = Lesson::where('teacher_id', $this->id)->where('status', 1)->get();
        return count($lessons);
    }

    public function getAvailableLessonsAttribute()
    {
        $lessons = Lesson::where('teacher_id', $this->id)->where('status', 0)->get();
        return count($lessons);
    }

    public function getFinishedLessonsAttribute()
    {
        $lessons = Lesson::where('teacher_id', $this->id)->where('status', 2)->get();
        return count($lessons);
    }
}