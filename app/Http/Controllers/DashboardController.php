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

        $studentMeta = [
            'title' => __('dashboard.student_dashboard_title'),
            'description' => __('dashboard.student_dashboard_description'),
            'img' => __('dashboard.student_dashboard_img')
        ];

        if ($user->role == 'student') {
	        return Inertia::render('Student/Dashboard')->with($this->renderStudentHub($user, $studentMeta));
        }

        $teacherMeta = [
            'title' => __('dashboard.teacher_dashboard_title'),
            'description' => __('dashboard.teacher_dashboard_description'),
            'img' => __('dashboard.teacher_dashboard_img')
        ];

    	if ($user->role == 'teacher') {
		    return Inertia::render('Teacher/Dashboard')->with($this->renderTeacherHub($user, $teacherMeta));
	    }
    }

    protected function renderStudentHub(User $user, $meta)
    {

        $lessons = $user->extra->lessons()
            ->distinct('teacher_id')
            ->with('teacher', 'teacher.lessons')
            ->get()->unique('teacher_id');

        $lessons->sortBy(function($lesson) {
            return $lesson->teacher->user->first_name;
        });

        $appointments = $user->extra->appointments()
            ->where('active', 1)
            ->where('end', '>', Carbon::now('UTC'))
            ->with(['teacher', 'teacher.user', 'student', 'student.user'])
            ->orderBy('start', 'ASC')
            ->get();

        return [
            'appointments' => $appointments,
            'lessons' => array_values($lessons->toArray()),
            'meta' => $meta
        ];
    }

    protected function renderTeacherHub(User $user, $meta)
    {
        $lessons = $user->extra->lessons()
            ->distinct('student_id')
            ->with('student')
            ->get()->unique('student_id');

        $lessons->sortBy(function($lesson) {
            return $lesson->student->user->first_name;
        });

	    $lessons_converted = [];
	    foreach($lessons as $lesson) {
		    $lessons_converted[] = $lesson;
	    }

        $appointments = $user->extra->appointments()
            ->where('active', 1)
            ->where('end', '>', Carbon::now('UTC'))
            ->with(['teacher', 'teacher.user', 'student', 'student.user'])
            ->orderBy('start', 'ASC')
            ->get();

        $availabilities = $user->extra->availabilities;

        return [
            'appointments' => $appointments,
            'lessons' => $lessons_converted,
            'availabilities' => $availabilities,
            'meta' => $meta
        ];
    }
}
