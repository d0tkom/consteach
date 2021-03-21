<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
    	$user = Auth::user();

    	if ($user->role == 'student') return Inertia::render('Student/Settings')->with(['timezoneList' => timezone_identifiers_list()]);

    	if ($user->role == 'teacher') return Inertia::render('Teacher/Settings')->with(['teacher' => $user->extra, 'timezoneList' => timezone_identifiers_list()]);
    }
}
