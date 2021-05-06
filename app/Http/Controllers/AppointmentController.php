<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Teacher;
use App\Notifications\AppointmentBooked;
use App\Notifications\AppointmentDeletedTeacher;
use App\Notifications\FreeAppointmentBookedStudent;
use App\Notifications\AppointmentDeletedStudent;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use MacsiDigital\Zoom\Facades\Zoom;

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
                'type' => 'normal',
                'active' => false,
                'student_approved' => false,
                'teacher_approved' => false,
            ]
        );

        $this->createMeeting($appointment);

        $lesson = auth()->user()->extra->lessons()->where('teacher_id', $request->input('params')['teacher_id'])->first();


        if ($lesson != null && $lesson->available > 0) {
            $appointment->active = true;

            $appointment->save();

            $lesson->decrement('available', 1);
            $lesson->increment('booked', 1);

            $lesson->save();

            $teacher = $appointment->teacher;
            $teacher->user->notify(new AppointmentBooked($appointment));
        } else {
            return response($appointment->id, 423);
        }

        return $appointment;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointmentCopy = $appointment;

        $lesson = auth()->user()->extra->lessons()->where('teacher_id', $appointment->teacher->id)->first();

        $lesson->decrement('booked', 1);
        $lesson->increment('available', 1);
        $lesson->save();

        $appointment->delete();

        $appointmentCopy->teacher->user->notify(new AppointmentDeletedTeacher($appointmentCopy));
        $appointmentCopy->student->user->notify(new AppointmentDeletedStudent($appointmentCopy));
    }

    public function createMeeting(Appointment $appointment)
    {

        $response = Http::withHeaders([
                'Authorization' => 'Bearer ea311513c0e75440e2493d89c71097c0a0af06eb3206b1b603eaaca9cfb29d34',
                'Content-Type' => 'application/json'
            ])
            ->post('https://api.daily.co/v1/rooms', [
                'properties' => [
                    'enable_network_ui' => false
                ],
            ]);

        $appointment->meeting_id = $response->json()['url'];

        $appointment->save();
    }
}
