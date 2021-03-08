<template>
	<money-format
		class="inline-block"
		:value="value"
		:locale="$page.props.user.site_language"
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
		if (this.currency_ === null) {
			this.currency_ = this.$page.props.user.currency;
		}
	}
}

</script>