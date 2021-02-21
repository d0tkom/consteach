<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use KgBot\LaravelLocalization\Classes\ExportLocalizations;
use App\Models\Teacher;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Appointment;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    switch (Auth::user()->role) {
        case ('student'):
            $lessons = Lesson::where('student_id', Auth::user()->extra->id)
                ->with('teacher') 
                ->get()
                ->sortBy(function($lesson, $key) {
                    return $lesson->teacher->user->first_name;
                });
            $appointments = Appointment::where('student_id', Auth::user()->extra->id)->where('student_approved', 0)->where('teacher_approved', 0)->with(['teacher', 'teacher.user', 'student', 'student.user'])->get();
            return Inertia\Inertia::render('Student/Dashboard')->with(['appointments' => $appointments, 'lessons' => $lessons]);
            break;
        case ('teacher'):
            $lessons = Lesson::where('teacher_id', Auth::user()->extra->id)
                ->with('student') 
                ->get()
                ->sortBy(function($lesson, $key) {
                    return $lesson->student->user->first_name;
                });
            $appointments = Appointment::where('teacher_id', Auth::user()->extra->id)->where('student_approved', 0)->where('teacher_approved', 0)->with(['teacher', 'teacher.user', 'student', 'student.user'])->get();
            return Inertia\Inertia::render('Teacher/Dashboard')->with(['appointments' => $appointments, 'lessons' => $lessons]);
            break;
        case ('admin'):
            return Inertia\Inertia::render('Admin/Dashboard');
            break;
        default:
            return view('welcome');
            break;
    }
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/teacher/{teacher_id}', function ($teacher_id) {
    $teacher = Teacher::where('id', $teacher_id)->with('user')->first();
    return Inertia\Inertia::render('Teacher/View')->with(['teacher' => $teacher]);
})->name('teacher.view');

Route::middleware(['auth:sanctum', 'verified'])->post('/checkout/payment', [CheckoutController::class, 'store']);

Route::middleware(['auth:sanctum', 'verified'])->get('/checkout/{teacher_id}', function ($teacher_id) {
    $teacher = Teacher::find($teacher_id);
    return Inertia\Inertia::render('Checkout')->with(['teacher' => $teacher]);
})->name('checkout');

Route::middleware(['auth:sanctum', 'verified'])->get('/settings', function () {
    switch (Auth::user()->role) {
        case ('student'):
            return Inertia\Inertia::render('Student/Settings');
            break;
        case ('teacher'):
            return Inertia\Inertia::render('Teacher/Settings');
            break;
        case ('admin'):
            return Inertia\Inertia::render('Admin/Dashboard');
            break;
        default:
            return view('welcome');
            break;
    }
    return Inertia\Inertia::render('Student/Settings');
})->name('settings');

Route::get('/get/local/data', function() {

    return ExportLocalizations::export()->toFlat();

//return response()->json($strings);
});

Route::resource('/users', UserController::class);

Route::get('login/{provider}', [LoginController::class, 'redirectToProvider'])->name('google.login');
Route::get('login/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->name('facebook.login');
