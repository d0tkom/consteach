<template>
	<c-pop-up
		:value="value"
		@close="$emit('input', false)"
	>
		<login @close="$emit('input', false)" />
	</c-pop-up>
</template>

<script>
import Login from '@/Pages/Auth/Login';

export default {
	props: {
		value: {
			type: Boolean,
			default: false
		}
	},
	components: {
		Login
	}
}
</script>