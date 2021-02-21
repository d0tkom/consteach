<template>
	<c-pop-up
		:value="value"
		@close="$emit('input', false)"
		title="Add meg régi és új jelszavad a változtatáshoz!"
	>
		<form @submit.prevent="save">
			<c-input
				class="mb-4"
				label="Jelenlegi jelszó"
				v-model="form.oldPassword"
			></c-input>
			
			<c-input
				class="mb-4"
				label="Új jelszó"
				v-model="form.newPasswordConfirm"
			></c-input>
			
			<c-input
				class="mb-4"
				label="Új jelszó újra"
				v-model="form.newPassword"
			></c-input>
			
			<div class="actions flex justify-center">
				<c-btn
					@click="save"
					icon="save"
					:loading="saving"
				>Mentés</c-btn>
			</div>
		</form>
	</c-pop-up>
</template>

<script>

export default {
	components: {

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
			saving: false,
			form: {
				oldPassword: null,
				newPassword: null,
				newPasswordConfirm: null
			}
		};
	},
	methods: {
		save() {
			console.warn('TODO:Saving password...');
			this.saving = true;
			
			setTimeout(() => {
				this.saving = false;
			}, 2000);
		}
	}
}
</script>