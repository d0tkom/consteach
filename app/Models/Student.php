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

    protected $fillable = [
    	'user_id',
    	'wanted_language',
    ];

    protected $appends = [
        'trial_available'
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
}