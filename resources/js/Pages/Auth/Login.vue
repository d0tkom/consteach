<template>
	<div>
        <jet-validation-errors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

		<div class="socialLogin">
			<c-btn
				class="mb-4"
				full
				color="facebook"
				icon="facebook"
				navigate-to="/login/facebook"
			>{{ trans.choice('auth.login_with_facebook_btn', 1) }}</c-btn>
			
			<c-btn
				full
				outlined
				navigate-to="/login/google?user_role=teacher"
			>
				<div class="flex items-center">
					<div class="googleIconContainer mr-4">
						<img src="/img/google_logo.svg" alt="Google logo">
					</div>
					<span>{{ trans.get('auth.login_with_google_btn') }}</span>
				</div>
			</c-btn>
		</div>
		
		<div class="hr">{{ trans.get('auth.login_social_or_email') }}</div>
		
        <form @submit.prevent="submit">
            <div>
                <c-input name="email" type="email" :label="trans.get('auth.email_label')" v-model="form.email" required autofocus />
            </div>

            <div class="mt-4">
                <c-input :label="trans.get('auth.email_label')" name="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
	                <c-checkbox
		                v-model="form.remember"
	                >{{ trans.get('auth.remember_label') }}</c-checkbox>
                </label>
            </div>

            <div class="flex items-center justify-center my-4">
	            <c-btn
		            :loading="form.processing"
	                @click="submit"
	            >{{ trans.get('auth.login_btn') }}</c-btn>
            </div>
	
	        <div class="flex justify-between">
		        <c-btn
			        text
			        navigate-to="/#lost-password"
		        >
			        {{ trans.get('auth.lost_password_btn') }}
		        </c-btn>
		        <c-btn
			        text
			        navigate-to="/#registration"
		        >{{ trans.get('auth.create_new_account_btn') }}
		        </c-btn>
	        </div>
        </form>
	</div>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    
    export default {
        components: {
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => {
	                        this.form.reset('password');
	                        this.$emit('close');
                        }
                    })
            }
        }
    }
</script>
