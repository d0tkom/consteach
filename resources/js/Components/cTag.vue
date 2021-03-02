<template>
	<div class="tagContainer" :class="[type, small && 'small']">
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
		}
	},
	watch: {

	},
	data: function() {
		return {

		};
	},
	methods: {

	}
}
</script>