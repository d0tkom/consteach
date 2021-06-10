<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ContactFormSubmit;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class ContactController extends Controller
{
    public function submitForm(Request $request) {
        $message = $request->message;
        $email = 'info@consteach.com';

        if (!$message) {
            return response()->json(['error' => 'message_not_specified'], 400);
        }

        (new User)->forceFill([
            'name' => 'ConsTeach [admin]',
            'email' => $email,
        ])->notify(new ContactFormSubmit($message));

        return response()->json(['status' => 'ok']);
    }
}
