<template>
	<app-layout>
		<div class="checkoutContainer m-auto flex justify-center max-w-xl">
			<div class="checkoutCol flex flex-col justify-center">
				<div class="p-4 m-4 blue-text-color bg-white rounded-xl shadow-md border border-blue-300 items-center relative">
					<div class="flex ">
						<span class="h-6 rounded-full w-6 border blue-border-color text-center text-md flex flex-col justify-center">1</span>
						<span class="mx-2 flex flex-col justify-center text-md font-semibold">Tanórák</span>
					</div>
					<div class="sm:my-4 sm:mx-8 m-2">
						<div class="mb-2">Hány órát szeretnél vásárolni?</div>
						<label for="e1" @click="selectProduct(1, teacher.one_hour_price, 'HUF')">
							<div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
								<input id="e1" class="mt-1 sm:mr-3" type="radio" name="lesson" />
								<div class="text-md font-semibold flex-1 mr-4">1 Tanóra</div>
								<div class="text-green-500 text-md">{{ teacher.one_hour_price*1.2 }} HUF</div>
							</div>
						</label>
						<label for="e2" @click="selectProduct(5, teacher.five_hour_price, 'HUF')">
							<div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
								<input id="e2" class="mt-1 sm:mr-3" type="radio" name="lesson" />
								<div class="text-md font-semibold flex-1 mr-4">5 Tanóra</div>
								<div class="text-md text-gray-500 line-through mr-2">{{ teacher.one_hour_price*1.2*5 }} HUF</div>
								<div class="text-green-500 text-md">{{ teacher.five_hour_price*1.2 }} HUF</div>
							</div>
						</label>
						<label for="e3" @click="selectProduct(10, teacher.ten_hour_price, 'HUF')">
							<div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
								<input id="e3" class="mt-1 sm:mr-3" type="radio" name="lesson" />
								<div class="text-md font-semibold flex-1 mr-4">10 Tanóra</div>
								<div class="text-md text-gray-500 line-through mr-2">{{ teacher.one_hour_price*1.2*10 }} HUF</div>
								<div class="text-green-500 text-md">{{ teacher.ten_hour_price*1.2 }} HUF</div>
							</div>
						</label>
					</div>
				</div>
				
				<div class="p-4 m-4 blue-text-color bg-white rounded-xl shadow-md border border-blue-300 items-center relative">
					<div class="flex">
						<span class="h-6  rounded-full w-6 border blue-border-color text-center text-md flex flex-col justify-center">2</span>
						<span class="mx-2 flex flex-col justify-center text-md font-semibold">Fizetés</span>
					</div>
					
					<div class="sm:my-4 sm:mx-8 m-2">
						
						<div class="mb-2">Fizetési adatok</div>
						<c-input
							class="mb-4"
							type="text"
							name="address"
							label="Address"
							v-model="billing.address"
							required
						/>
						<c-input
							class="mb-4"
							type="text"
							name="city"
							label="City"
							v-model="billing.city"
							required
						/>
						
						<c-input
							class="mb-4"
							type="text"
							name="state"
							label="State"
							v-model="billing.state"
							required
						/>
						
						<c-input
							class="mb-4"
							type="text"
							name="postal"
							label="Postal"
							v-model="billing.postal"
							required
						/>
						
						<div id="card-element"></div>
						
						<button
							id="card-button"
							@click="processPayment()"
							:disables="paymentProcessing"
							v-text="paymentProcessing ? 'Processing' : 'Pay Now'"
						>
							Process Payment
						</button>
					</div>
				</div>
			</div>
			
			<div class="checkoutCol max-w-md m-4">
				<div class="p-4 blue-text-color bg-white rounded-xl shadow-md border border-blue-300 items-center relative">
					<div class="flex">
						<span class="h-6  rounded-full w-6 border blue-border-color text-center text-md flex flex-col justify-center">3</span>
						<span class="mx-2 flex flex-col justify-center text-md font-semibold">Fizetés befejezése</span>
					</div>
					
					<div class="m-4 text-center">
						<img class="object-cover mx-auto h-14 w-14 rounded-full m-auto" :src="teacher.user.profile_photo_url" alt="Tanár profilképe">
						<span class="mx-2 font-semibold">{{ teacher.user.first_name }} {{ teacher.user.last_name }}</span>
					</div>
					
					<div class="mx-2">
						<div class="flex">
							<span class="text-md flex-1">Termék neve</span>
							<span class="text-md">Összeg</span>
						</div>
						<hr class="my-1">
						<div><span class="font-semibold">{{ product.lesson_number }} Tanóra</span> 60 perc</div>
						<hr class="mb-2 mt-4">
						<div class="flex justify-end mb-8">
							<div class="flex">
								<div class="w-28 sm:w-32">
									<div class="text-green-500 text-md">Összeg:</div>
									<div class="text-gray-500 text-xs">Illeték</div>
									<div class="text-green-500 text-md font-semibold mt-2">Teljes összeg:</div>
								</div>
								<div>
									<div class="text-green-500 text-md text-right">{{ (product.amount-product.fee)/100 }} {{ product.currency }}</div>
									<div class="text-gray-500 text-xs text-right">{{ product.fee/100 }} {{ product.currency }}</div>
									<div class="text-green-500 text-md font-semibold mt-2 text-right">{{ product.amount/100 }} {{ product.currency }}</div>
								</div>
							</div>
						</div>
						<div class="flex sm:justify-end justify-center mb-2">
							<c-btn
								@click="processPayment"
								:loading="paymentProcessing"
							>
								Fizetés
							</c-btn>
						</div>
					</div>
				</div>
				<div class="p-4 items-center relative">
					<p class="text-xs blue-text-color">
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
					</p>
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>
    import AppLayout from './../Layouts/AppLayout'
    import Welcome from './../Jetstream/Welcome'
    import {loadStripe} from '@stripe/stripe-js'

    export default {
        components: {
            AppLayout,
            Welcome,
        },
        props: {
            teacher: Object
        },
        data() {
            return {
                product: {
                    lesson_number: null,
                    amount: null,
                    currency : null,
                    teacher_id: null,
                    payment_method: null,
                    fee: null,
                },
                billing: {
                    address: null,
                    city: null,
                    state: null,
                    postal: null,
                },
                stripe: {},
                cardElement: {},
                paymentProcessing: false,
            }
        },
        computed : {
            fee: function () {
                return this.product.amount * 0.8;
            }
        }, 
        async mounted() {
            this.stripe = await loadStripe('pk_test_51IJzZ5BL1awehvPyAmK3WX8hXKt8NZYxV2q9KFu1VIuO0GFAkt3YIJefhmO2J2cKkt6xuWlnDjUw6ejJYEN4xV2300ss9XpQPd');
            const elements = this.stripe.elements();
            this.cardElement = elements.create('card', {
                hidePostalCode: true,
                classes: {
                    base: 'mt-1 sm:mr-3',
                },
	            style: {
		            paymentRequestButton: {
		                color: 'red'
		            },
		            base: {
			            paymentRequestButton: {
				            color: 'red'
			            },
		            	padding: '20px',
			            iconColor: '#c4f0ff',
			            color: 'black',
			            fontWeight: '500',
			            fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
			            fontSize: '16px',
			            fontSmoothing: 'antialiased',
			            ':-webkit-autofill': {
				            color: '#fce883',
			            },
			            '::placeholder': {
				            color: '#87BBFD',
			            },
		            },
		            invalid: {
			            iconColor: '#FFC7EE',
			            color: '#FFC7EE',
		            },
	            },
            });
            this.cardElement.mount('#card-element');
        },
        created() {
            this.product.teacher_id = this.$props.teacher.id;
        },
        methods: {
            selectProduct: function (lesson_number, amount, currency) {
                this.product.lesson_number = lesson_number;
                this.product.amount = amount*1.2*100;
                this.product.fee = (amount*1.2-amount)*100;
                this.product.currency = currency;
            },
            async processPayment() {
                this.paymentProcessing = true;

                const {paymentMethod, error} = await this.stripe.createPaymentMethod(
                    'card', this.cardElement, {
                        billing_details: {
                            name: this.$page.props.user.first_name + '' + this.$page.props.user.last_name,
                            email: this.$page.props.user.email,
                            address: {
                                line1: this.billing.address,
                                city: this.billing.city,
                                state: this.billing.state,
                                postal_code: this.billing.postal
                            }

                        }
                    }
                );

                if (error) {
                    this.paymentProcessing = false;
                    alert(error);
                } else {
                    this.product.payment_method = paymentMethod.id;
                    axios.post('payment', {billing: this.billing, product: this.product})
                        .then((response) => {
                            this.paymentProcessing = false;
	                        this.$toast.success('Sikeres tranzakció');
                            //redirect here
                        })
                        .catch((error) => {
                            this.paymentProcessing = false;
                            console.error(error);
	                        this.$toast.error('Sikertelen tranzakció');
                        });
                }
            }
        }
    }
</script>
