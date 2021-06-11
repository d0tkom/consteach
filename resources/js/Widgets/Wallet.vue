<template>
	<div
		class="walletWidget shadow-lg p-4 bg-white blue-border flex flex-col justify-between items-center"
		:class="{opened}"
	>
		<div class="font-bold text-md color-primary-dark">{{ trans.get('header.wallet_total') }}</div>

		<div class="value text-xl color-green-dark font-bold">
			<currency
                :value="$page.props.user.extra.available_payout"
            />
		</div>
		<c-btn
			icon="payments"
			@click.prevent="payout()"
		>
			{{ trans.get('header.payment_btn') }}
		</c-btn>
	</div>
</template>

<script>

export default {
	props: {
		value: {
			type: Boolean,
			default: false
		},
	},
	data() {
		return {
			opened: false,
			clickListener: null
		};
	},
	watch: {
		value(value) {
			this.opened = value;
		},
	},
	methods: {
		onClose() {
			if (this.opened) {
				this.opened = false;
				this.$emit('input', false);
			}
		},
		payout() {
            axios.post('/checkout/payout/' + this.$page.props.user.extra.id)
            .then(response => {
            	console.log(response)
                //this.$toast.success(message);
            })
            .catch(error => {
                console.error(error);
                //this.$toast.error(message);
            });
        },
	}
}
</script>