<template>
	<c-pop-up
		:value="value"
		@close="$emit('input', false)"
		:title="trans.get('settings.delete_profile_popup_title')"
	>
		<delete-user-form />
	</c-pop-up>
</template>

<script>
import DeleteUserForm from '../Pages/Profile/DeleteUserForm.vue';

export default {
	components: {
		DeleteUserForm
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
			loading: false,
		};
	},
	methods: {

	}
}
</script>