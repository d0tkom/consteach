<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Helpers\CollectionHelper;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
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
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        if ($request->input('step') == 0) {
            $validatedData = $request->validate([
                'first_name' => ['required', 'min:2', 'max:50'],
                'last_name' => ['required', 'min:2', 'max:50'],
                'email' => ['required', 'min:2', 'max:50', 'email'],
                'country' => ['required'],
                'timezone' => ['required'],
                'spoken_languages' => ['required', 'array', 'min:1'],
                'teaching_languages' => ['required', 'array', 'min:1'],
                'adult' => ['required', 'accepted'],
            ]);
        } elseif ($request->input('step') == 1) {
            $validatedData = $request->validate([
                'profile_photo' => ['required', 'file', 'image'],
            ]);
        } elseif ($request->input('step') == 2) {
            $validatedData = $request->validate([
                'video_url' => ['required', 'active_url'],
            ]);
        } elseif ($request->input('step') == 3) {
            $validatedData = $request->validate([
                'about_me' => ['required', 'array'],
            ]);
        } else {
            /*$validatedData = $request->validate([
                'validation_photo' => ['required', 'file', 'image'], //TODO: WTF legyen ezzel 
            ]);*/
        }

        return redirect(route('teacher-application'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        //
    }

    public function filter(Request $request)
    {
        $teachers = Teacher::whereBetween('one_hour_price', [request()->input('prices')[0], request()->input('prices')[1]])
            ->with(['user', 'availabilities']);

        if (request()->input('language')) {
            $teachers->where('teaching_languages', 'LIKE', '%"language": "'.request()->input('language').'"%');
        }

        if (request()->input('order_by') == 'one_hour_price') {
            $teachers->orderBy(request()->input('order_by'), 'ASC');
            $teachers = $teachers->get();
        } else {
            $teachers = $teachers->get();
            $teachers->sortBy(request()->input('order_by'));
        }

        if (json_decode(request()->input('time'))->timeOfDay) {
            $teachers = $teachers->filter(function ($teacher) {
                return !$teacher->availabilities->filter(function ($availabilitiy) {
                    $start = json_decode(request()->input('time'))->timeOfDay[0]->start;
                    $end = json_decode(request()->input('time'))->timeOfDay[0]->end;
                    $compare_start = Carbon::createFromTimeString($start)->format('H');
                    $compare_end = Carbon::createFromTimeString($end)->format('H');
                    $time = Carbon::create($availabilitiy->start)->tz('UTC')->setTimezone(Auth::check() ? auth()->user()->timzezone : 'Europe/Budapest')->format('H');

                    if ($time >= $compare_start && $time <= $compare_end) {
                        return true;
                    } else {
                        return false;
                    }
                    
                })->isEmpty();
            });
        }

        if (json_decode(request()->input('time'))->day) {
            $teachers = $teachers->filter(function ($teacher) {
                return !$teacher->availabilities->whereIn('weekday', json_decode(request()->input('time'))->day)->isEmpty();
            });
        }

        $teachers = CollectionHelper::paginate($teachers, 5);

        return response()->json(['teachers' => $teachers]);
    }
}
