<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\AppointmentController;
use App\Helpers\CollectionHelper;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use KgBot\LaravelLocalization\Classes\ExportLocalizations;
use App\Models\Teacher;
use App\Models\Lesson;
use App\Models\Appointment;
use App\Models\Availability;
use Inertia\Inertia;

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

// AUTH REDIRECTS
Route::get('/login', function () {
    return redirect('/#login');
})->name('login');

Route::get('/register', function () {
    return redirect('/#registration');
})->name('register');

Route::get('/forgotten-password', function () {
    return redirect('/#lost-password');
})->name('forgotten-password');

Route::get('/faq', function() {
    return Inertia::render('Faq');
});

// LEGAL routes
Route::get('/terms-and-conditions', function() {
    return Inertia::render('TermsAndConditions');
});

Route::get('/cookie-policy', function() {
    return Inertia::render('CookiePolicy');
});

Route::get('/privacy-policy', function() {
    return Inertia::render('PrivacyPolicy');
});

Route::get('/currency', [CurrencyController::class, 'fetchExchange']);

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }

    $teachersAvailableLanguages = Teacher::select(['teaching_languages'])->get();

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

    return Inertia::render('Landing')->with(['availableLanguages' => $availableLanguages]);
})->name('landing');
/*
Route::get('/teacher-landing', function () {
    return Inertia::render('TeacherLanding');
})->name('teacher-landing');
*/
Route::get('/teacher/{teacher_id}', function ($teacher_id) {
    $appointments = Appointment::where('teacher_id', $teacher_id)->where('active', 1)->get();

    $availabilities = Availability::where('teacher_id', $teacher_id)->get();

    $teacher = Teacher::where('id', $teacher_id)->with('user')->first();

    return Inertia::render('Teacher/View')->with(['teacher' => $teacher, 'appointments' => $appointments, 'availabilities' => $availabilities]);
})->name('teacher.view');

Route::put('/availability', [AvailabilityController::class, 'store'])->name('availability.store');
Route::delete('/availability/{availability}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');
Route::put('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
Route::delete('/appointment/{appointment}', [AppointmentController::class, 'destroy'])->name('appointment.destroy');

Route::get('/teachers', function (Request $request) {
    $teachersAvailableLanguages = Teacher::select(['teaching_languages'])->where('complete', true)->where('validated', true)->get();

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
    $teachers = Teacher::with('user')->where('complete', true)->where('validated', true)->orderBy('one_hour_price', 'ASC')->get();
    $teachers = CollectionHelper::paginate($teachers, 5);

    return Inertia::render('Teacher/List')->with(['all_teachers' => $teachers, 'availableLanguages' => $availableLanguages]);
})->name('teachers');

Route::get('teachers/load-more', [TeacherController::class, 'load_more'])->name('teachers.more');

Route::get('/teachers/filter', [TeacherController::class, 'filter'])->name('teachers.filter');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::middleware(['teacher.registered', 'teacher.verified'])->get('/dashboard', function () {
        switch (Auth::user()->role) {
        case ('student'):
            $lessons = Lesson::where('student_id', Auth::user()->extra->id)
                ->with('teacher') 
                ->get()
                ->sortBy(function($lesson, $key) {
                    return $lesson->teacher->user->first_name;
                });

            $appointments = Appointment::where('student_id', Auth::user()->extra->id)->where('active', 1)->where('student_approved', 0)->where('teacher_approved', 0)->with(['teacher', 'teacher.user', 'student', 'student.user'])->orderBy('start', 'ASC')->get();

            return Inertia::render('Student/Dashboard')->with(['appointments' => $appointments, 'lessons' => $lessons]);
            break;
        case ('teacher'):
            $lessons = Lesson::where('teacher_id', Auth::user()->extra->id)
                ->with('student') 
                ->get()
                ->sortBy(function($lesson, $key) {
                    return
                     $lesson->student->user->first_name;
                });
            $appointments = Appointment::where('teacher_id', Auth::user()->extra->id)->where('active', 1)->where('student_approved', 0)->where('teacher_approved', 0)->with(['teacher', 'teacher.user', 'student', 'student.user'])->orderBy('start', 'ASC')->get();

            $availabilities = Availability::where('teacher_id', Auth::user()->extra->id)->get();

            return Inertia::render('Teacher/Dashboard')->with(['appointments' => $appointments, 'lessons' => $lessons, 'availabilities' => $availabilities]);
            break;
        case ('admin'):
            return Inertia::render('Admin/Dashboard');
            break;
        default:
            return view('welcome');
            break;
    }
    })->name('dashboard');

    Route::get('/teacher-application', function () {
        $teacher = Teacher::where('user_id', Auth::user()->id)->first();
        $timezones = timezone_identifiers_list();
        return Inertia::render('Teacher/Application')->with(['teacher' => $teacher, 'timezoneList' => $timezones]);
    })->name('teacher-application');

    Route::post('/checkout/payment', [CheckoutController::class, 'store']);

    Route::get('/checkout/{teacher_id}', function ($teacher_id) {
        $teacher = Teacher::with('user')->find($teacher_id);

        $appointment = Appointment::find(request()->input('appointment'));

        return Inertia::render('Checkout')->with(['teacher' => $teacher, 'appointment' => $appointment]);
    })->name('checkout');

    Route::put('/teacher/{teacher}', [TeacherController::class, 'update'])->name('teacher.update');
    Route::post('/teacher/{teacher}', [TeacherController::class, 'update']);

    Route::middleware(['teacher.registered', 'teacher.verified'])->get('/settings', function () {
        switch (Auth::user()->role) {
            case ('student'):
                $timezones = timezone_identifiers_list();
                return Inertia::render('Student/Settings')->with(['timezoneList' => $timezones]);
                break;
            case ('teacher'):
                $timezones = timezone_identifiers_list();
                $teacher = Teacher::where('user_id', Auth::user()->id)->first();
                return Inertia::render('Teacher/Settings')->with(['teacher' => $teacher, 'timezoneList' => $timezones]);
                break;
            case ('admin'):
                return Inertia::render('Admin/Dashboard');
                break;
            default:
                return view('welcome');
                break;
        }
    })->name('settings');
});

Route::get('/get/local/data', function() {
    return ExportLocalizations::export()->toFlat();
});

Route::resource('/users', UserController::class);

Route::get('login/{provider}', [LoginController::class, 'redirectToProvider'])->name('google.login');
Route::get('login/{provider}/callback', [LoginController::class, 'handleProviderCallback']);