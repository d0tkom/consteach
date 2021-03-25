<template>
	<c-pop-up
		:value="value"
		@close="$emit('input', false)"
		:title="trans.get('auth.forgot_password_title')"
	>
		<div class="mb-4">{{ trans.get('auth.forgot_password_subtitle') }}</div>
		<forgot-password @close="$emit('input', false)" />
	</c-pop-up>
</template>

<script>
import ForgotPassword from "@/Pages/Auth/ForgotPassword";

export default {
	props: {
		value: {
			type: Boolean,
			default: false
		}
	},
	components: {
		ForgotPassword,
	}
}
</script>