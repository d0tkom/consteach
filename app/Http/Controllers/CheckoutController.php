<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Appointment;

class CheckoutController extends Controller
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
        $student = auth()->user()->extra;

        if ($request->input('product')['amount'] == 0) {
            return $this->TrialPayment($request->input('appointment')['id'] ?? null, $student->id);
        }

        $student->address = $request->input('billing')['address'];
        $student->city = $request->input('billing')['city'];
        $student->state = $request->input('billing')['state'];
        $student->postal = $request->input('billing')['postal'];

        $student->save();

        try {
            $user = auth()->user();
            $user->createOrGetStripeCustomer();

            /*$payment = $user->charge(
                $request->input('product')['amount'],
                $request->input('product')['payment_method']

            );*/

            //$payment = $payment->asStripePaymentIntent();

            $payment = $user->invoiceFor('Lesson Fee', $request->input('product')['amount'],[],[
                'default_payment_method' => $request->input('product')['payment_method']
            ]);

            var_Dump($payment);

            $order = $user->orders()
                ->create([
                    'transaction_id' => '311',
                    'total' => '3131',
                    'teacher_id' => $request->input('product')['teacher_id'],
                    'lesson_number' => $request->input('product')['lesson_number'],
                ]);

            $order->save();

            $lesson = Lesson::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'teacher_id' => $request->input('product')['teacher_id']
                ]
            );

            $lesson->increment('available', $request->input('product')['lesson_number']);

            if ($request->input('appointment') != null) {
                $appointment = Appointment::where('id', $request->input('appointment')['id'])->first();
                $appointment->active = true;
                $appointment->type = 'normal';
                $appointment->save();

                $lesson->decrement('available', 1);
                $lesson->increment('booked', 1);
            }

            $lesson->save();

            return $order;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
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
        //
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

    public function TrialPayment($appointment_id, $student_id)
    {
        $user = auth()->user();

        $lesson = Lesson::firstOrCreate(
            [
                'student_id' => $student_id,
                'teacher_id' => request()->input('product')['teacher_id']
            ]
        );

        $lesson->increment('booked', 1);

        $lesson->save();

        if ($appointment_id != null) {
            $appointment = Appointment::where('id', $appointment_id)->first();
            $appointment->active = true;
            $appointment->type = 'try';
            $appointment->save();
        }

        return true;
    }
}
