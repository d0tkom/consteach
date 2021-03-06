<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;

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

// STRIPE WEBHOOK
Route::post('/webhook/stripe/payment/success', [CheckoutController::class, 'stripePaymentSuccessWebhook']);

Route::get('/', [HomeController::class, 'index'])->name('landing');

Route::get('/login', function () { return redirect('/#login'); })->name('login');
Route::get('/register', function () { return redirect('/#registration'); })->name('register');
Route::get('/forgotten-password', function () { return redirect('/#lost-password'); })->name('forgotten-password');

//Route::get('/teacher-landing', function () { return Inertia::render('TeacherLanding'); })->name('teacher-landing');
Route::get('/faq-teacher', function() {
    $meta = [
        'title' => __('faq_teacher.document_title'),
        'description' => __('faq_teacher.document_description'),
        'img' => __('faq_teacher.document_img')
    ];

    return Inertia::render('Teacher/Faq')->with(['meta' => $meta]);
});
Route::get('/faq-student', function() {
    $meta = [
        'title' => __('faq_student.document_title'),
        'description' => __('faq_student.document_description'),
        'img' => __('faq_student.document_img')
    ];

    return Inertia::render('Student/Faq')->with(['meta' => $meta]);
});

Route::post('/contact', [ContactController::class, 'submitForm']);

Route::get('/terms-and-conditions', function() {
    $meta = [
        'title' => __('legal.terms_and_conditions_document_title'),
        'description' => __('legal.terms_and_conditions_document_description'),
        'img' => __('legal.terms_and_conditions_document_image')
    ];

    return Inertia::render('TermsAndConditions')->with(['meta' => $meta]);
});
Route::get('/cookie-policy', function() {
    $meta = [
        'title' => __('legal.cookie_policy_document_title'),
        'description' => __('legal.cookie_policy_document_description'),
        'img' => __('legal.cookie_policy_document_image')
    ];

    return Inertia::render('CookiePolicy')->with(['meta' => $meta]);
});
Route::get('/privacy-policy', function() {
    $meta = [
        'title' => __('legal.privacy_policy_document_title'),
        'description' => __('legal.privacy_policy_document_description'),
        'img' => __('legal.privacy_policy_document_image')
    ];

    return Inertia::render('PrivacyPolicy')->with(['meta' => $meta]);
});

Route::put('/availability', [AvailabilityController::class, 'store'])->name('availability.store');
Route::delete('/availability/{availability}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');

Route::put('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
Route::delete('/appointment/{appointment}', [AppointmentController::class, 'destroy'])->name('appointment.destroy');
Route::post('/appointment/meeting/{appointment}', [AppointmentController::class, 'startMeeting'])->name('appointment.meeting.start');

Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers');
Route::get('teacher/{teacher}', [TeacherController::class, 'show'])->name('teacher.view');
Route::put('/teacher/{teacher}', [TeacherController::class, 'update'])->name('teacher.update');
Route::post('/teacher/{teacher}', [TeacherController::class, 'update']);
Route::get('teachers/load-more', [TeacherController::class, 'load_more'])->name('teachers.more');
Route::get('/teachers/filter', [TeacherController::class, 'filter'])->name('teachers.filter');

Route::get('/teachers/validation', [TeacherController::class, 'validation'])->name('teachers.validation');
Route::post('/teachers/validate/{teacher}', [TeacherController::class, 'validateTeacher'])->name('teachers.validate');

Route::resource('/users', UserController::class);

Route::get('login/{provider}', [LoginController::class, 'redirectToProvider'])->name('google.login');
Route::get('login/{provider}/callback', [LoginController::class, 'handleProviderCallback']);

Route::get('/currency', [CurrencyController::class, 'fetchExchange']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/teacher-application', [TeacherController::class, 'application'])->name('teacher-application');

    Route::post('/checkout/payment', [CheckoutController::class, 'store']);
    Route::get('/checkout/{teacher}', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout/payout/{teacher}', [CheckoutController::class, 'payout'])->name('stripe.payout');
    Route::get('/connect/{token}', [CheckoutController::class, 'saveStripeAccount'])->name('stripe.save');

    Route::middleware(['teacher.registered', 'teacher.verified'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    });
});