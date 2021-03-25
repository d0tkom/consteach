<template>
	<c-pop-up
		:value="value"
		@close="$emit('input', false)"
	>
		<register @close="$emit('input', false)" />
	</c-pop-up>
</template>

<script>
import Register from '@/Pages/Auth/Register';

export default {
	props: {
		value: {
			type: Boolean,
			default: false
		}
	},
	components: {
		Register
	}
}
</script>