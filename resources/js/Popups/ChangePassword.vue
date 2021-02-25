<template>
	<c-pop-up
		:value="value"
		@close="$emit('input', false)"
		title="Add meg régi és új jelszavad a változtatáshoz!"
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
	methods: {

	}
}
</script>