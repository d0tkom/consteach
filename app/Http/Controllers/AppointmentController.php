<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
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
        $appointment = Appointment::create(
                [
                    'teacher_id' => $request->input('params')['teacher_id'],
                    'student_id' => auth()->user()->extra->id,
                    'start' => Carbon::create($request->input('params')['start'])->tz('UTC'),
                    'end' => Carbon::create($request->input('params')['end'])->tz('UTC'),
                    'type' => '??',
                    'student_approved' => false,
                    'teacher_approved' => false,
                ]
            );

        return $appointment;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointments
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointments
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointments)
    {
        //
    }
}
