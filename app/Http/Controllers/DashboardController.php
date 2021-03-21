<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
    	$user = Auth::user();

    	if ($user->role == 'student') return Inertia::render('Student/Dashboard')->with($this->renderStudentHub($user));

    	if ($user->role == 'teacher') return Inertia::render('Teacher/Dashboard')->with($this->renderTeacherHub($user));
    }

    protected function renderStudentHub(User $user)
    {
    	$lessons = $user->extra->lessons()
            ->with('teacher') 
            ->get()
            ->sortBy(function($lesson, $key) {
                return $lesson->teacher->user->first_name;
            });

        $appointments = $user->extra->appointments()
        	->where('active', 1)
        	->where('student_approved', 0)
        	->where('teacher_approved', 0)
            ->where('end', '>', Carbon::now('UTC'))
        	->with(['teacher', 'teacher.user', 'student', 'student.user'])
        	->orderBy('start', 'ASC')
        	->get();

        return ['appointments' => $appointments, 'lessons' => $lessons];
    }

    protected function renderTeacherHub(User $user) 
    {
    	$lessons = $user->extra->lessons()
            ->with('student') 
            ->get()
            ->sortBy(function($lesson, $key) {
                return $lesson->student->user->first_name;
            });

        $appointments = $user->extra->appointments()
        	->where('active', 1)
        	->where('student_approved', 0)
        	->where('teacher_approved', 0)
            ->where('end', '>', Carbon::now('UTC'))
        	->with(['teacher', 'teacher.user', 'student', 'student.user'])
        	->orderBy('start', 'ASC')
        	->get();

        $availabilities = $user->extra->availabilities();

        return ['appointments' => $appointments, 'lessons' => $lessons, 'availabilities' => $availabilities];
    }
}
