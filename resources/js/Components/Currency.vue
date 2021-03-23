<template>
	<money-format
		class="inline-block"
		:value="valueConverted"
		:locale="$page.props.user ? $page.props.user.site_language : 'hu'"
		:currency-code="currency_"
		:subunits-value="false"
		:hide-subunits="true"
	/>
</template>

<script>
import MoneyFormat from 'vue-money-format'

export default {
	components: {
		MoneyFormat
	},
	props: {
		value: {
			type: Number,
			default: 0
		},
		currency: {
			type: String,
			default: null
		}
	},
	data() {
		return {
			currency_: this.currency
		};
	},
	mounted() {
		if (this.currency_ != null) {
			return;
		}
		
		if (!this.$page.props.user) {
			this.currency_ = 'HUF';
			return;
		}
		
		this.currency_ = this.$page.props.user.currency;
	},
	computed: {
		valueConverted() {
			if (this.currency_ === 'HUF') {
				return this.value;
			}
			
			let exchange = this.$root.currencies[this.currency_];
			
			return this.value * exchange;
		}
	}
}

</script>