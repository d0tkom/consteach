<template>
	<form @submit.prevent="updatePassword">
		<div>
			<div class="mb-4">
				<c-input
					:label="trans.get('auth.current_password_label')"
					name="current_password"
					type="password"
					v-model="form.current_password"
					ref="current_password"
					autocomplete="current-password"
					:error="!!form.errors.current_password"
				/>
			</div>
			
			<div class="mb-4">
				<c-input
					:label="trans.get('auth.new_password_label')"
					name="password"
					type="password"
					v-model="form.password"
					autocomplete="password"
					ref="password"
					:error="!!form.errors.password"
				/>
			</div>
			
			<div class="mb-4">
				<c-input
					:label="trans.get('auth.new_password_confirmation_label')"
					name="password_confirmation"
					type="password"
					v-model="form.password_confirmation"
					ref="password_confirmation"
					autocomplete="password_confirmation"
					:error="!!form.errors.password_confirmation"
				/>
			</div>
		</div>
		
		<div class="flex justify-center">
			<c-btn
				@click="updatePassword"
				:loading="form.processing"
			>
				{{ trans.get('auth.password_update_save_btn') }}
			</c-btn>
		</div>
	</form>
</template>

<script>

export default {
	components: {
	},
	data() {
		return {
			form: this.$inertia.form({
				current_password: '',
				password: '',
				password_confirmation: '',
			}),
		}
	},
	
	methods: {
		updatePassword() {
			this.form.put(route('user-password.update'), {
				errorBag: 'updatePassword',
				preserveScroll: true,
				onSuccess: () => {
					this.form.reset();
					this.$emit('close');
					let message = this.trans.get('auth.password_update_success_notification');
					this.$toast.success(message);
				},
				onError: () => {
					if (this.form.errors.password) {
						this.form.reset('password', 'password_confirmation')
						this.$refs.password.focus()
					}
					
					if (this.form.errors.current_password) {
						this.form.reset('current_password')
						this.$refs.current_password.focus()
					}
					
					let message = this.trans.get('auth.password_update_success_notification');
					this.$toast.error(message);
				}
			})
		},
	},
}
</script>
