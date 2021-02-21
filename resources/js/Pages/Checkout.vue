<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ trans.get('titles.profile') }}
            </h2>
        </template>

        <div class="p-4 max-w-md mx-auto blue-text-color bg-white rounded-xl shadow-md border border-blue-300 items-center relative">
            <div class="flex ">
                <span class="h-6  rounded-full w-6 border blue-border-color text-center text-md flex flex-col justify-center">1</span>
                <span class="mx-2 flex flex-col justify-center text-md font-semibold ">Tanórák</span>
            </div>
            <div class="sm:my-4 sm:mx-8 m-2">
                <div class="mb-2">Hány órát szeretnél vásárolni?</div>
                <label for="e1" @click="selectProduct(1, teacher.one_hour_price, 'HUF')">
                    <div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
                        <input id="e1" class="mt-1 sm:mr-3" type="radio" name="lesson" />
                        <div class="text-md font-semibold flex-1">1 Tanóra</div>
                        <div class="text-green-500 text-md">{{ teacher.one_hour_price*1.2 }} HUF</div>
                    </div>
                </label>
                <label for="e2" @click="selectProduct(5, teacher.five_hour_price, 'HUF')">
                <div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
                    <input id="e2" class="mt-1 sm:mr-3" type="radio" name="lesson" />
                    <div class="text-md font-semibold flex-1">5 Tanóra</div>
                    <div class="text-md text-gray-500 line-through mr-2">{{ teacher.one_hour_price*1.2*5 }} HUF</div>
                    <div class="text-green-500 text-md">{{ teacher.five_hour_price*1.2 }} HUF</div>
                </div>
                </label>
                <label for="e3" @click="selectProduct(10, teacher.ten_hour_price, 'HUF')">
                <div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
                    <input id="e3" class="mt-1 sm:mr-3" type="radio" name="lesson" />
                    <div class="text-md font-semibold flex-1">10 Tanóra</div>
                    <div class="text-md text-gray-500 line-through mr-2">{{ teacher.one_hour_price*1.2*10 }} HUF</div>
                    <div class="text-green-500 text-md">{{ teacher.ten_hour_price*1.2 }} HUF</div>
                </div>
                </label>
            </div>
        </div>

        <div class="p-4 max-w-md mx-auto blue-text-color bg-white rounded-xl shadow-md border border-blue-300 items-center relative">
            <div class="flex ">
                <span class="h-6  rounded-full w-6 border blue-border-color text-center text-md flex flex-col justify-center">2</span>
                <span class="mx-2 flex flex-col justify-center text-md font-semibold ">Fizetés</span>
            </div>

            <div class="sm:my-4 sm:mx-8 m-2">
                
                <div class="mb-2">Fizetési adatok</div>
                    <label for="f1">
                        <div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
                            <input id="f1" class="mt-1 sm:mr-3" type="text" name="address" placeholder="Address" v-model="billing.address" required/>
                        </div>
                    </label>
                    <label for="f2">
                        <div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
                            <input id="f2" class="mt-1 sm:mr-3" type="text" name="city" placeholder="City" v-model="billing.city" required/>
                        </div>
                    </label>
                    <label for="f3">
                        <div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
                            <input id="f3" class="mt-1 sm:mr-3" type="text" name="city" placeholder="State" v-model="billing.state" required/>
                        </div>
                    </label>
                    <label for="f4">
                        <div class="sm:flex border rounded p-1 mb-2 sm:text-left text-center select-none line-hover">
                            <input id="f4" class="mt-1 sm:mr-3" type="text" name="postal" placeholder="Postal" v-model="billing.postal" required/>
                        </div>
                    </label>
                    <div id="card-element"></div>
                    

                    <button id="card-button" @click="processPayment()" :disables="paymentProcessing" v-text="paymentProcessing ? 'Processing' : 'Pay Now'">
                        Process Payment
                    </button>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <h1>Összefoglaló</h1>
                    <div v-show="product">
                        <p>{{ product.lesson_number }} Tanóra (60 perc)</p>
                        <p>Összeg: {{ (product.amount-product.fee)/100 }} {{ product.currency }}</p>
                        <p>Illeték: {{ product.fee/100 }} {{ product.currency }}</p>
                        <p>Teljes összeg: {{ product.amount/100 }} {{ product.currency }}</p>
                    </div>
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
                    paymnet_method: null,
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
                return this.product.amount * 0,8;
            }
        }, 
        async mounted() {
            this.stripe = await loadStripe('pk_test_51IJzZ5BL1awehvPyAmK3WX8hXKt8NZYxV2q9KFu1VIuO0GFAkt3YIJefhmO2J2cKkt6xuWlnDjUw6ejJYEN4xV2300ss9XpQPd');
            const elements = this.stripe.elements();
            this.cardElement = elements.create('card', {
                hidePostalCode: true,
                classes: {
                    base: 'mt-1 sm:mr-3',
                }
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
                            //redirect here
                        })
                        .catch((error) => {
                            this.paymentProcessing = false;
                            alert(error);
                        });
                }
            }
        }
    }
</script>
