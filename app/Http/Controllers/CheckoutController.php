<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Student;
use App\Notifications\FreeAppointmentBookedStudent;
use App\Notifications\FreeAppointmentBookedTeacher;
use App\Notifications\LessonBoughtTeacher;
use Exception;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Appointment;
use App\Models\Teacher;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Carbon\Carbon;
use BillingoApiV3Wrapper as BillingoApi;
use Laravel\Cashier\Exceptions\PaymentActionRequired;
use Stripe\Event as StripeEvent;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use UnexpectedValueException;

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

	public function stripePaymentSuccessWebhook() {
		$payload = @file_get_contents('php://input');

		try {
			$event = StripeEvent::constructFrom(
				json_decode($payload, true)
			);
		} catch(UnexpectedValueException $e) {
			// Invalid payload
			http_response_code(400);
			exit();
		}

		// Handle the event
		if ($event->type === 'payment_intent.succeeded') {
			$paymentIntent = $event->data->object;
			$paymentIntentId = $paymentIntent->id;
			$transactionId = $paymentIntent->charges->data[0]->id;;

			$order = Order::where('transaction_id', $paymentIntentId)->first();

			if (!$order) {
				return response()->json(["message" => "Order not found"], 500);
			}

			$order->active = 1;
			$order->transaction_id = $transactionId;
			$order->save();

			$student = Student::where("user_id", $order->user_id)->first();

			$this->finalizeOrder(
				$order->lesson_number,
				$student->id,
				$order->teacher_id,
				$order->total,
				$order->appointment_id,
				$order
			);
		}
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

        if (!$teacher->finished_onboarding) {
            return $this->reditectToStripe($teacher);
        } else {
            $lessons = Lesson::where('teacher_id', $teacher->id)->where('payout_available', 1)->get();

            if ($lessons) {
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
            }

            return $this->reditectToStripe($teacher);
        }
    }

    private function createLesson($studentId, $teacherId, $price) {
	    $lesson = Lesson::create([
		    'student_id' => $studentId,
		    'teacher_id' => $teacherId,
		    'price' => $price,
		    'status' => 0
	    ]);

    	return $lesson;
    }

    private function registerOrder($user, $teacherId, $lessonNumber, $amount, $appointmentId) {
	    $order = $user->orders()
		    ->create([
			    'transaction_id' => null,
			    'total' => $amount,
			    'teacher_id' => $teacherId,
			    'lesson_number' => $lessonNumber,
			    'appointment_id' => $appointmentId
		    ]);

	    $order->save();

	    return $order;
    }

	/**
	 * @param $lessonNumber
	 * @param $studentId
	 * @param $teacherId
	 * @param $amount
	 * @param $appointmentId
	 */
	private function finalizeOrder($lessonNumber, $studentId, $teacherId, $amount, $appointmentId, $order) {
	    for ($i = 0; $i < $lessonNumber; $i++) {
		    $price = ($amount)*0.8/$lessonNumber;

		    $lesson = $this->createLesson($studentId, $teacherId, $price);
	    }

	    if ($appointmentId != null) {
		    $appointment = Appointment::where('id', $appointmentId)->first();
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $student = auth()->user()->extra;
	    $amount = $request->input('product')['amount'];

        if ($amount == 0) {
            return $this->TrialPayment($request->input('appointment')['id'] ?? null, $student->id);
        }

        $student->address = $request->input('billing')['address'];
        $student->city = $request->input('billing')['city'];
        $student->country = $request->input('billing')['country'];
        $student->postal = $request->input('billing')['postal'];

	    $teacherId = $request->input('product')['teacher_id'];
	    $lessonNumber = $request->input('product')['lesson_number'];
	    $appointmentId = $request->input('appointment') ? $request->input('appointment')['id'] : null;
	    $paymentMethod = $request->input('product')['payment_method'];

        $student->save();

        try {
	        $user = auth()->user();
	        $user->createOrGetStripeCustomer();

	        $order = $this->registerOrder($user, $teacherId, $lessonNumber, $amount, $appointmentId);

	        $payment = $user->charge(
		        $amount,
		        $paymentMethod
	        );

	        $payment = $payment->asStripePaymentIntent();

	        $order->transaction_id = $payment->charges->data[0]->id;
	        $order->save();

	        $this->finalizeOrder($lessonNumber, $student->id, $teacherId, $amount, $appointmentId, $order);
        } catch (PaymentActionRequired $exception) {
        	$order->transaction_id = $exception->payment->id;
	        $order->save();

	        return response()->json([
	        	'payment_client_secret' => $exception->payment->clientSecret()
	        ]);
        } /*catch(Exception $exception) {
	        return response()->json([
	        	'message' => $exception->getMessage()
	        ], 500);
        }*/
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
		$teacherId = request()->input('product')['teacher_id'];

	    $lesson = $this->createLesson($student_id, $teacherId, 0);

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
            'net_unit_price' => intval(round(($order->total - $order->total*0.8)/100)),
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