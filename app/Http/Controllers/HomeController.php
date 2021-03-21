<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
	    if (Auth::check()) {
	        return redirect('/dashboard');
	    }

	    $availableLanguages = Teacher::getAllLanguages();

	    return Inertia::render('Landing')->with(['availableLanguages' => $availableLanguages]);
    }
}
