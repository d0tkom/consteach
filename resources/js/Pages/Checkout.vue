<template>
	<app-layout>
		<div class="checkoutContainer m-auto flex justify-center max-w-xl">
			<div class="checkoutCol flex flex-col">
				<div class="p-4 m-4 blue-text-color bg-white rounded-xl shadow-md border border-blue-300 items-center relative">
					<div class="flex ">
						<span class="h-6 rounded-full w-6 border blue-border-color text-center text-md flex flex-col justify-center">1</span>
						<span class="mx-2 flex flex-col justify-center text-md font-semibold">{{ trans.get('checkout.lessons') }}</span>
					</div>
					<div class="sm:my-4 sm:mx-8 m-2">
						<div class="mb-2">{{ trans.get('checkout.how_many_hours') }}</div>
						<label for="e0" v-if="$page.props.user.extra.trial_available && appointment" @click="trialSelected = true; selectTrial()">
							<div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
								<input id="e0" class="mt-1 sm:mr-3" type="radio" name="lesson" :checked="trialSelected"/>
								<div class="text-md font-semibold flex-1 mr-4">{{ trans.get('checkout.free_lesson') }}</div>
							</div>
						</label>
						<label for="e1" @click="trialSelected = false; selectProduct(1, teacher.one_hour_price, 'HUF')">
							<div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
								<input id="e1" class="mt-1 sm:mr-3" type="radio" name="lesson" :checked="!trialSelected" />
								<div class="text-md font-semibold flex-1 mr-4">1 {{ trans.choice('checkout.lesson', 1) }}</div>
								<div class="text-green-500 text-md">
									<currency
										:value="teacher.one_hour_price/$root.fee"
									/>
								</div>
							</div>
						</label>
						<label for="e2" @click="trialSelected = false; selectProduct(5, teacher.five_hour_price, 'HUF')">
							<div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
								<input id="e2" class="mt-1 sm:mr-3" type="radio" name="lesson" />
								<div class="text-md font-semibold flex-1 mr-4">5 {{ trans.choice('checkout.lesson', 5) }}</div>
								<div class="text-md text-gray-500 mr-2" v-if="teacher.one_hour_price/$root.fee*5 > teacher.five_hour_price">
									<currency
										class="line-through"
										:value="teacher.one_hour_price/$root.fee*5"
									/>
								</div>
								<div class="text-green-500 text-md">
									<currency
										:value="teacher.five_hour_price/$root.fee"
									/>
								</div>
							</div>
						</label>
						<label for="e3" @click="trialSelected = false; selectProduct(10, teacher.ten_hour_price, 'HUF')">
							<div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
								<input id="e3" class="mt-1 sm:mr-3" type="radio" name="lesson" />
								<div class="text-md font-semibold flex-1 mr-4">10 {{ trans.choice('checkout.lesson', 10) }}</div>
								<div class="text-md text-gray-500 mr-2" v-if="teacher.one_hour_price/$root.fee*10 > teacher.ten_hour_price">
									<currency
										class="line-through"
										:value="teacher.one_hour_price/$root.fee*10"
									/>
								</div>
								<div class="text-green-500 text-md">
									<currency
										:value="teacher.ten_hour_price/$root.fee"
									/>
								</div>
							</div>
						</label>
						<label for="e4" @click="trialSelected = false; selectProduct(20, teacher.twenty_hour_price, 'HUF')">
							<div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
								<input id="e4" class="mt-1 sm:mr-3" type="radio" name="lesson" />
								<div class="text-md font-semibold flex-1 mr-4">20 {{ trans.choice('checkout.lesson', 20) }}</div>
								<div class="text-md text-gray-500 mr-2" v-if="teacher.one_hour_price/$root.fee*20 > teacher.twenty_hour_price">
									<currency
										class="line-through"
										:value="teacher.one_hour_price/$root.fee*20"
									/>
								</div>
								<div class="text-green-500 text-md">
									<currency
										:value="teacher.twenty_hour_price/$root.fee"
									/>
								</div>
							</div>
						</label>
					</div>
				</div>
				
				<div class="p-4 m-4 blue-text-color bg-white rounded-xl shadow-md border border-blue-300 items-center relative" :class="{invisible: trialSelected }">
					<div class="flex">
						<span class="h-6  rounded-full w-6 border blue-border-color text-center text-md flex flex-col justify-center">2</span>
						<span class="mx-2 flex flex-col justify-center text-md font-semibold">{{ trans.get('checkout.payment') }}</span>
					</div>
					
					<div class="sm:my-4 sm:mx-8 m-2">
						<div class="mb-2">{{ trans.get('checkout.payment_info_label') }}</div>
						<c-input
							class="mb-4"
							type="text"
							name="address"
							:label="trans.get('checkout.address_label')"
							v-model="billing.address"
							required
						/>
						<c-input
							class="mb-4"
							type="text"
							name="city"
							:label="trans.get('checkout.city_label')"
							v-model="billing.city"
							required
						/>

						<c-select
							class="mb-4"
							capitalize
							:data="countries"
							:label="trans.get('checkout.country_label')"
							labelKey="name"
							valueKey="code"
							:selected="billing.country"
							v-model="billing.country"
						/>
						
						<c-input
							class="mb-4"
							type="text"
							name="postal"
							:label="trans.get('checkout.postal_label')"
							v-model="billing.postal"
							required
						/>
						
						<div class="mb-2 mt-4">{{ trans.get('checkout.bank_card_info_label') }}</div>
						<div id="card-element"></div>
					</div>
				</div>
			</div>
			
			<div class="checkoutCol max-w-md m-4">
				<div class="p-4 blue-text-color bg-white rounded-xl shadow-md border border-blue-300 items-center relative">
					<div class="flex">
						<span class="h-6  rounded-full w-6 border blue-border-color text-center text-md flex flex-col justify-center">{{ trialSelected ? '2' : '3' }}</span>
						<span class="mx-2 flex flex-col justify-center text-md font-semibold">{{ trans.get('checkout.end_of_checkout') }}</span>
					</div>
					
					<div class="m-4 text-center">
						<img class="object-cover mx-auto h-14 w-14 rounded-full m-auto" :src="teacher.user.profile_photo_url" alt="Tanár profilképe">
						<span class="mx-2 font-semibold">{{ teacher.user.first_name }} {{ teacher.user.last_name[0] }}.</span>
					</div>

					<div class="m-4 text-center" v-if="appointment">
						<div>
							<c-date
								with-day
								:value="appointment.start"
							/>
						</div>
						<c-date
							class="text-2xl font-bold color-primary-dark"
							only-time
							:value="appointment.start"
						/>
					</div>
					
					<div class="mx-2">
						<div class="flex">
							<span class="text-md flex-1">{{ trans.get('checkout.product_name') }}</span>
							<span class="text-md">{{ trans.get('checkout.price') }}</span>
						</div>
						<hr class="my-2">
						<div class="productRow flex items-center justify-between">
							<div>
								<span class="font-semibold">{{ product.lesson_number }} {{ trans.choice('checkout.lesson', product.lesson_number) }}</span> 60 {{ trans.choice('checkout.minute', 60) }}
							</div>
							<div
								v-if="product.amount > 0"
								class="flex justify-end"
							>
								<currency
									:value="product.amount/100"
								/>
							</div>
							<div
								v-else
								class="flex justify-end font-bold color-green-dark"
							>{{ trans.get('checkout.free') }}</div>
						</div>
						<hr class="my-2">
						<div class="flex justify-end mb-8" v-show="!trialSelected">
							<div class="flex">
								<div class="w-28 sm:w-32">
									<div class="text-green-500 text-md">{{ trans.get('checkout.price') }}:</div>
									<div class="text-gray-500 text-xs">{{ trans.get('checkout.fee') }}:</div>
									<div class="text-green-500 text-md font-semibold mt-2">{{ trans.get('checkout.total_price') }}:</div>
								</div>
								<div>
									<div class="text-green-500 text-md text-right">
										<currency
											:value="(product.amount-product.fee)/100"
											:currency="product.currency"
										/>
									</div>
									<div class="text-gray-500 text-xs text-right">
										<currency
											:value="product.fee/100"
											:currency="product.currency"
										/>
									</div>
									<div class="text-green-500 text-md font-semibold mt-2 text-right">
										<currency
											:value="product.amount/100"
											:currency="product.currency"
										/>
									</div>
								</div>
							</div>
						</div>
						<div class="flex sm:justify-end justify-center mb-2">
							<c-btn
								@click="processPayment"
								:loading="paymentProcessing"
							>
								{{ trans.get(trialSelected ? 'checkout.free_lesson_pay_btn' : 'checkout.pay_btn') }}
							</c-btn>
						</div>
					</div>
				</div>
				<div class="p-4 items-center relative">
					<p class="text-xs blue-text-color">
						{{ trans.get('checkout.footer_info') }}
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
            teacher: Object,
            appointment: Object
        },
        data() {
            return {
            	trialSelected: this.$page.props.user.extra ? this.$page.props.user.extra.trial_available : true,
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
					country: "HU",
                    postal: null,
                },
				countries: null,
                stripe: {},
                cardElement: {},
                paymentProcessing: false,
	            locale: window.default_locale,
            }
        },
        async mounted() {
            this.stripe = await loadStripe('pk_live_51IJzZ5BL1awehvPyrHviKgBvcqZXkcWLjBWNoyHRrL3BkfT52upQZ9DvweI14ULrVk3zEoxUhnvByh5Ggi5VBC8g00Rin5gQVb');
            const elements = this.stripe.elements({
	            locale: 'hu'
            });

            this.cardElement = elements.create('card', {
                hidePostalCode: true,
                classes: {
                    base: 'mt-1 sm:mr-3',
                },
	            style: {
		            paymentRequestButton: {
		                color: 'red'
		            },
		            empty: {
		            	padding: '20px'
		            },
		            base: {
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
            
            this.$nextTick(() => {
	            this.cardElement.mount('#card-element');
            });
        },
        created() {
	        let title = this.trans.get('checkout.document_title');
	        this.$root.documentTitle(title);
        	
            this.product.teacher_id = this.$props.teacher.id;
            if (!this.trialSelected) {
            	this.selectProduct(1, this.teacher.one_hour_price, 'HUF');
            }

			this.countries = require('i18n-iso-countries');
			this.countries.registerLocale(require('i18n-iso-countries/langs/en.json'));
			this.countries.registerLocale(require('i18n-iso-countries/langs/hu.json'));
			this.countries.registerLocale(require('i18n-iso-countries/langs/de.json'));

			this.countries = Object.entries(this.countries.getNames(this.locale, {select: 'official'})).map(array => {
				return {code: array[0], name: array[1]};
			});
	
			this.countries.sort(this.$root.sortAlphabetByName);
        },
        methods: {
        	selectTrial: function () {
        		this.product = {
                    lesson_number: 1,
                    amount: 0,
                    currency : 'HUF',
                    payment_method: null,
                    fee: 0,
                };
        	},
            selectProduct: function (lesson_number, amount, currency) {
                this.product.lesson_number = lesson_number;
                this.product.amount = amount/this.$root.fee*100;
                this.product.fee = (amount/this.$root.fee-amount)*100;
                this.product.currency = currency;
            },
	        getBillingDetails() {
		        return {
			        name: this.$page.props.user.first_name + '' + this.$page.props.user.last_name,
				        email: this.$page.props.user.email,
			        address: {
				        line1: this.billing.address,
				        city: this.billing.city,
				        state: this.billing.state,
				        postal_code: this.billing.postal
			        }
		        }
	        },
	        confirmPayment(paymentClientSecret, paymentMethod) {
		        this.paymentProcessing = true;

		        this.stripe.confirmCardPayment(paymentClientSecret, {
			        payment_method: {
				        card: this.cardElement,
				        billing_details: this.getBillingDetails
			        },
		        })
		        .then(result => {
			        if (result.error) {
				        console.error(result.error);
				        this.paymentProcessing = false;
				        this.$toast.error(result.error.message);
			        } else {
				        this.paymentProcessing = false;
				        this.$inertia.visit('/dashboard');
				        let message = this.trans.get('checkout.transaction_success_notification');
				        this.$toast.success(message);
			        }
		        })
	        },
            async processPayment() {
                this.paymentProcessing = true;
                if (this.trialSelected) {
                	axios.post('payment', {appointment: this.appointment, billing: this.billing, product: this.product})
                        .then(response => {
                            this.paymentProcessing = false;
                            let message = this.trans.get('checkout.transaction_success_notification');
	                        this.$toast.success(message);
	                        this.$inertia.visit('/dashboard');
                        })
                        .catch(error => {
	                        console.error(error);
                            this.paymentProcessing = false;
                            let message = this.trans.get('checkout.transaction_fail_notification');
	                        this.$toast.error(message);
                        });
                        
                	return;
                }

                const {paymentMethod, error} = await this.stripe.createPaymentMethod(
                    'card', this.cardElement, {
                        billing_details: this.getBillingDetails
                    }
                );

                if (error) {
                    this.paymentProcessing = false;
                    alert(error);
                } else {
                    this.product.payment_method = paymentMethod.id;
                    axios.post('payment', {appointment: this.appointment, billing: this.billing, product: this.product})
                        .then(({data}) => {
	                        this.paymentProcessing = false;

                        	if (data.payment_client_secret) {
		                        return this.confirmPayment(data.payment_client_secret, paymentMethod);
	                        }

                            this.$inertia.visit('/dashboard');
	                        let message = this.trans.get('checkout.transaction_success_notification');
	                        this.$toast.success(message);
                        })
                        .catch((error) => {
	                        this.paymentProcessing = false;
	                        console.error(error);
	                        let message = this.trans.get('checkout.transaction_fail_notification');
	                        this.$toast.error(message);
                        }
                    );
                }
            }
        }
    }
</script>
