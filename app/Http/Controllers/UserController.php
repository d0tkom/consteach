<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'first_name' => ['bail', 'required', 'min:2', 'max:50'],
            'last_name' => ['bail', 'required', 'min:2', 'max:50'],
            'email' => ['bail', 'required', 'min:2', 'max:50', 'email']
        ]);

        $user = User::find($id);

        $user->first_name = request()->input('first_name');
        $user->last_name = request()->input('last_name');
        $user->email = request()->input('email');
        $user->timezone = request()->input('timezone');
        $user->spoken_languages = request()->input('spoken_languages');
        $user->site_language = request()->input('site_language');
        $user->currency = request()->input('currency');

        $user->save();

        if ($user->role == 'teacher') {
            $teacher = Teacher::where('user_id', $user->id)->first();

            $teacher->teaching_languages = request()->input('teaching_languages');
            $teacher->about_me = request()->input('about_me');
            $teacher->country = request()->input('country') ?? 'hu';
            $teacher->video_url = request()->input('video_url');
            $teacher->one_hour_price = request()->input('one_hour_price');
            $teacher->five_hour_price = request()->input('five_hour_price');
            $teacher->ten_hour_price = request()->input('ten_hour_price');

            $teacher->save();
        }

        return redirect(route('settings'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
