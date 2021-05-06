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

        $studentMeta = [
            'title' => __('settings.document_title'),
            'description' => __('settings.document_description'),
            'img' => __('settings.document_img')
        ];

    	if ($user->role == 'student') return Inertia::render('Student/Settings')->with([
    	    'timezoneList' => timezone_identifiers_list(),
            'meta' => $studentMeta
        ]);

        $teacherMeta = [
            'title' => __('settings.document_title'),
            'description' => __('settings.document_description'),
            'img' => __('settings.document_img')
        ];

    	if ($user->role == 'teacher') return Inertia::render('Teacher/Settings')->with([
    	    'teacher' => $user->extra,
            'timezoneList' => timezone_identifiers_list(),
            'meta' => $teacherMeta
        ]);
    }
}
