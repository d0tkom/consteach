<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use KgBot\LaravelLocalization\Classes\ExportLocalizations;

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
            return Inertia\Inertia::render('Student/Dashboard');
            break;
        case ('teacher'):
            return Inertia\Inertia::render('Teacher/Dashboard');
            break;
        case ('admin'):
            return Inertia\Inertia::render('Admin/Dashboard');
            break;
        default:
            return view('welcome');
            break;
    }
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/teacher/calendar', function () {
    return Inertia\Inertia::render('Teacher/Calendar');
})->name('teacher.calendar');

Route::middleware(['auth:sanctum', 'verified'])->get('/teacher/students', function () {
    return Inertia\Inertia::render('Teacher/Students');
})->name('teacher.students');

Route::middleware(['auth:sanctum', 'verified'])->get('/teacher/settings', function () {
    return Inertia\Inertia::render('Teacher/Settings');
})->name('teacher.settings');

Route::middleware(['auth:sanctum', 'verified'])->get('/teacher/invoices', function () {
    return Inertia\Inertia::render('Teacher/Invoices');
})->name('teacher.invoices');

Route::middleware(['auth:sanctum', 'verified'])->get('/student/settings', function () {
    return Inertia\Inertia::render('Student/Settings');
})->name('student.settings');

Route::get('/get/local/data', function() {

    return ExportLocalizations::export()->toFlat();

//return response()->json($strings);
});

Route::resource('/users', UserController::class);

Route::get('login/{provider}', [LoginController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [LoginController::class, 'handleProviderCallback']);
