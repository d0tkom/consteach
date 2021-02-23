<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Helpers\CollectionHelper;
use Illuminate\Http\Request;

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
        //
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
            ->with('user');

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

        $teachers = CollectionHelper::paginate($teachers, 1);

        return response()->json(['teachers' => $teachers]);
    }
}
