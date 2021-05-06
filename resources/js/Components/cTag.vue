<template>
	<div
		class="tagContainer"
		:class="[type, rounded && 'rounded', priceTag && 'priceTag', small && 'small']">
		<slot />
	</div>
</template>

<script>

export default {
	props: {
		type: {
			type: String,
			default: 'primary'
		},
		small: {
			type: Boolean,
			default: false
		},
		rounded: {
			type: Boolean,
			default: false
		},
		priceTag: {
			type: Boolean,
			default: false
		}
	},
	data: function() {
		return {

		};
	}
}
</script>