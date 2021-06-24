<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use App\Models\Teacher;
use App\Helpers\CollectionHelper;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $availableLanguages = Teacher::getAllLanguages();

        $teachers = Teacher::with('user')->where('complete', true)->where('validated', true)->orderBy('one_hour_price', 'ASC')->get();
        $teachers = CollectionHelper::paginate($teachers, 5);

        $meta = [
            'title' => __('find_teacher.document_title'),
            'description' => __('find_teacher.document_description'),
            'img' => __('find_teacher.document_img')
        ];

        return Inertia::render('Teacher/List')->with([
            'all_teachers' => $teachers,
            'availableLanguages' => $availableLanguages,
            'meta' => $meta
        ]);
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
     * @return \Inertia\Response
     */
    public function show(Teacher $teacher)
    {
        $appointments = Appointment::where('teacher_id', $teacher->id)
            ->where('active', 1)
            ->where('start', '>', Carbon::now('UTC')->addHours(12));

        $appointments = $appointments->get();

        $availabilities = Availability::where('teacher_id', $teacher->id)
            ->where('start', '>', Carbon::now('UTC'));//->addHours(12));

        $availabilities = $availabilities->get();

        $teacher->user;

        $name = $teacher->user->first_name." ".$teacher->user->last_name[0].".";

        $meta = [
            'title' => __('teacher_profile.document_title', ['name' => $name]),
            'description' => __('teacher_profile.document_description'),
            'img' => __('teacher_profile.document_img')
        ];

        return Inertia::render('Teacher/View')->with([
            'teacher' => $teacher,
            'appointments' => $appointments,
            'availabilities' => $availabilities,
            'meta' => $meta,
        ]);
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
                'one_hour_price' => ['bail', 'required', 'numeric', 'min:0', 'not_in:0'],
                'five_hour_price' => ['bail', 'required', 'numeric', 'min:0', 'not_in:0', 'max:'.$request->input('one_hour_price')*5],
                'ten_hour_price' => ['bail', 'required', 'numeric', 'min:0', 'not_in:0', 'max:'.$request->input('one_hour_price')*10],
                'twenty_hour_price' => ['bail', 'required', 'numeric', 'min:0', 'not_in:0', 'max:'.$request->input('one_hour_price')*20],
            ]);
        } elseif ($request->input('step') == 1) {
            $validatedData = $request->validate([
                'photo' => ['required', 'file', 'max:2048'],
            ]);
        } elseif ($request->input('step') == 2) {
            $validatedData = $request->validate([
                'video_url' => ['required', 'active_url'],
            ]);
        } elseif ($request->input('step') == 3) {
            $validatedData = $request->validate([
                'about_me' => ['required', 'array'],
                "about_me.*.text"    => ["required", "min:250"],
            ]);
        } else {
            $validatedData = $request->validate([
                'validation_photo' => ['required', 'file', 'max:2048'],
            ]);
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

    public function load_more(Request $request)
    {
        $teachers = Teacher::with('user')->where('complete', true)->where('validated', true)->orderBy('one_hour_price', 'ASC')->get();
        $teachers = CollectionHelper::paginate($teachers, 5);

        if ($request->ajax()) {
            return response()->json(['teachers' => $teachers]);
        } else {
            abort(404);
        }
    }

    public function filter(Request $request)
    {
        $teachers = Teacher::where('complete', true)->where('validated', true)->whereBetween('one_hour_price', [request()->input('prices')[0], request()->input('prices')[1]])
            ->with(['user', 'availabilities']);

        if (request()->input('language')) {
            $teachers->where('teaching_languages', 'LIKE', '%"language": "'.request()->input('language').'"%');
        }

        if (request()->input('order_by') == 'one_hour_price') {
            $teachers->orderBy(request()->input('order_by'), 'ASC');
            $teachers = $teachers->get();
        } elseif (request()->input('order_by') == 'appointment_count') {
            $teachers = $teachers->get();
            $teachers->sortBy(request()->input('order_by'));
        } elseif (request()->input('order_by') == 'random') {
            $teachers = $teachers->inRandomOrder()->get();
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

    public function application()
    {
        $meta = [
            'title' => __('teacher_application.document_title'),
            'description' => __('teacher_application.document_description'),
            'img' => __('teacher_application.document_img')
        ];

        return Inertia::render('Teacher/Application')->with([
            'teacher' => Auth::user()->extra,
            'timezoneList' => timezone_identifiers_list(),
            'meta' => $meta
        ]);
    }

    public function validation()
    {
        $teachers = Teacher::with('user')->where('complete', true)->where('validated', false)->get();


        return Inertia::render('Teacher/Validate')->with([
            'all_teachers' => $teachers,
        ]);
    }

    public function validateTeacher(Teacher $teacher)
    {
        $teacher->validated = true;
        $teacher->save();

        return back();
    }
}
