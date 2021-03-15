<template>
	<c-pop-up
		:value="value"
		@close="$emit('input', false)"
		:title="trans.get('settings.change_password_popup_title')"
	>
		<update-password-form
			@close="$emit('input', false)"
		/>
	</c-pop-up>
</template>

<script>
import UpdatePasswordForm from "@/Pages/Profile/UpdatePasswordForm";

export default {
	components: {
		UpdatePasswordForm,
	},
	props: {
		value: {
			type: Boolean,
			default: false
		},
	},
	data: function() {
		return {
			active: this.value,

		};
	},
}
</script>