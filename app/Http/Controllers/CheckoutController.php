<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Appointment;
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
        $student->country = $request->input('billing')['state'];
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

            $partner_id = $this->createOrUpdateInvoicePartner();

            $product_id = $this->createProduct($order);

            $invoice_id = $this->createInvoice($order, $product_id);

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

            BillingoApi::api('Document')->sendInvoice($invoice_id)->getResponse();

            BillingoApi::api('Product')->delete($product_id)->getResponse();

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
            'name' => $order->lesson_number . ' Tanóra',
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