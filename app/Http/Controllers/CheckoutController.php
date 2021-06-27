<?php

namespace App\Http\Controllers;

use App\Notifications\FreeAppointmentBookedStudent;
use App\Notifications\FreeAppointmentBookedTeacher;
use App\Notifications\LessonBoughtTeacher;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Appointment;
use App\Models\Teacher;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Carbon\Carbon;
use BillingoApiV3Wrapper as BillingoApi;

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

    public function createStripeSellerAccount($stripe)
    {
        $account = $stripe->accounts->create([
            'type' => 'express',
            'country' => auth()->user()->extra->country,
            'email' => auth()->user()->email,
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'transfers' => ['requested' => true],
            ],
        ]);

        return $account;
    }

    public function reditectToStripe(Teacher $teacher)
    {
        $user = auth()->user();

        $stripe = new \Stripe\StripeClient(
            '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'
        );

        if (!$teacher->finished_onboarding) {
            $token = Str::random();
            $teacher->stripe_token = $token;
            $teacher->save();

            if (!$user->partner_id) {
                $user->partner_id = $this->createStripeSellerAccount($stripe)->id;
                $user->save();
            }

            $onboardLink = $stripe->accountLinks->create([
                'account' => $user->partner_id,
                'refresh_url' => route('stripe.payout', ['teacher' => $teacher->id]),
                'return_url' => route('stripe.save', ['token' => $token]),
                'type' => 'account_onboarding',
            ]);

            return $onboardLink->url;
        }

        $loginLink = $stripe->accounts->createLoginLink($user->partner_id);

        return $loginLink->url;
    }

    public function saveStripeAccount($token)
    {
        $teacher = Teacher::where('stripe_token', $token)->first();

        if (is_null($teacher->stripe_token)) {
            abort(404);
        }

        $teacher->finished_onboarding = true;
        $teacher->save();

        return redirect('/dashboard');
    }

    public function payout(Teacher $teacher)
    {
        $user = auth()->user();

        if (!$user->finished_onboarding) {
            return $this->reditectToStripe($teacher);
        } else {
            $lessons = Lesson::where('teacher_id', $teacher->id)->where('payout_available', true)->get();

            $total = 0;

            foreach ($lessons as $lesson) {
                $total += $lesson->price;
                $lesson->payout_available = false;
                $lesson->save();
            }

            $stripe = new \Stripe\StripeClient(
              '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'
            );
            $stripe->transfers->create([
              'amount' => $total,
              'currency' => 'huf',
              'destination' => $teacher->user->partner_id
            ]);

            return $this->reditectToStripe($teacher);
        }
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
        $student->country = $request->input('billing')['country'];
        $student->postal = $request->input('billing')['postal'];

        $student->save();

        try {
            $user = auth()->user();
            $user->createOrGetStripeCustomer();

            $payment = $user->charge(
                $request->input('product')['amount'],
                $request->input('product')['payment_method']
            );

            $payment = $payment->asStripePaymentIntent();

            $order = $user->orders()
                ->create([
                    'transaction_id' => $payment->charges->data[0]->id,
                    'total' => $payment->charges->data[0]->amount,
                    'teacher_id' => $request->input('product')['teacher_id'],
                    'lesson_number' => $request->input('product')['lesson_number'],
                ]);

            $order->save();

            $lesson = 0;

            for ($i = 0; $i < $request->input('product')['lesson_number']; $i++) {
                $lesson = Lesson::create(
                    [
                        'student_id' => $student->id,
                        'teacher_id' => $request->input('product')['teacher_id'],
                        'price' => ($payment->charges->data[0]->amount)/1.2,
                        'status' => 0
                    ]
                );
            }

            if ($request->input('appointment') != null) {
                $appointment = Appointment::where('id', $request->input('appointment')['id'])->first();
                $appointment->active = true;
                $appointment->type = 'normal';
                $appointment->lesson_id = $lesson->id;
                $appointment->save();

                $lesson->status = 1;
            }

            $lesson->save();

            $partner_id = $this->createOrUpdateInvoicePartner();

            $product_id = $this->createProduct($order);

            $invoice_id = $this->createInvoice($order, $product_id);
            
            BillingoApi::api('Document')->sendInvoice($invoice_id)->getResponse();

            BillingoApi::api('Product')->delete($product_id)->getResponse();

            $lesson->teacher->user->notify(new LessonBoughtTeacher($lesson));

            return $order;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show(Request $request, Teacher $teacher)
    {
        $appointment = Appointment::find(request()->input('appointment'));

        $teacher->user;

        $meta = [
            'title' => __('checkout.document_title'),
            'description' => __('checkout.document_description'),
            'img' => __('checkout.document_img')
        ];

        return Inertia::render('Checkout')->with([
            'teacher' => $teacher,
            'appointment' => $appointment,
            'meta' => $meta
        ]);
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

        $lesson = Lesson::create(
            [
                'student_id' => $student_id,
                'teacher_id' => request()->input('product')['teacher_id'],
                'price' => 0,
                'status' => 0
            ]
        );

        if ($appointment_id != null) {
            $appointment = Appointment::where('id', $appointment_id)->first();
            $appointment->active = true;
            $appointment->type = 'try';
            $appointment->lesson_id = $lesson->id;
            $appointment->save();

            $lesson->status = 1;
            $lesson->save();

            $appointment->teacher->user->notify(new FreeAppointmentBookedTeacher($appointment));
            $appointment->student->user->notify(new FreeAppointmentBookedStudent($appointment));
        }

        return true;
    }

    public function createOrUpdateInvoicePartner()
    {
        $partner = [
            'name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'address' => [
                'country_code' => auth()->user()->extra->country,
                'post_code' => auth()->user()->extra->postal,
                'city' => auth()->user()->extra->city,
                'address' => auth()->user()->extra->address,
            ],
            'emails' => [auth()->user()->email],
            'taxcode' => '',
        ];

        try {
            if (auth()->user()->partner_id) {
                $partner_id = BillingoApi::api('Partner')->make($partner)->model('Partner')->update(auth()->user()->partner_id)->getId();
            } else {
                $partner_id = BillingoApi::api('Partner')->make($partner)->model('PartnerUpsert')->create()->getId();
                $user = auth()->user();
                $user->partner_id = $partner_id;
                $user->save();
            }

            return $partner_id;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function createProduct($order)
    {
        $product = [
            'name' => trans_choice('bill.lesson', $order->lesson_number),
            'net_unit_price' => intval(round(($order->total - $order->total/1.2)/100)),
            'currency' => 'HUF',
            'unit_price_type' => 'gross',
            'unit' => 'db',
            'vat' => 'AAM',
            'comment' => '',
        ];

        $product_id = BillingoApi::api('Product')->make($product)->model('Product')->create()->getId();

        return $product_id;
    }

    public function createInvoice($order, $product_id)
    {
        $invoice = [
            'partner_id' => auth()->user()->partner_id,
            'block_id' => 100130,
            'bank_account_id' => 28357,
            'type' => 'invoice',
            'fulfillment_date' => Carbon::now('Europe/Budapest')->format('Y-m-d'),
            'due_date' => Carbon::now('Europe/Budapest')->format('Y-m-d'),
            'payment_method' => 'bankcard',
            'language' => auth()->user()->site_language,
            'currency' => 'HUF',
            'conversion_rate' => 1,
            'electronic' => true,
            'paid' => true,
            'items' =>  [
                [
                    'product_id' => $product_id,
                    'quantity' => 1,
                ],
            ],
            'comment' => '',
            'settings' => [
                'mediated_servicíe' => false,
                'without_financial_fulfillment' => true,
                'online_payment' => '',
                'round' => 'five',
                'place_id' => 0,
            ],
        ];

        $invoice_id = BillingoApi::api('Document')->make($invoice)->model('DocumentInsert')->create()->getId();
            
        return $invoice_id;
    }
}