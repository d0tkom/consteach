<template>
	<div class="slideoutContent p-4">
		<c-btn
			class="slideoutCloseBtn"
			icon="close"
			icon-only
			text
			circle
			@click="$root.hideLoginPopup()"
		></c-btn>

		<div class="flex justify-center my-4 mb-8">
			<logo
				class="brandLogo"
				:width="200"
				:height="60"
			/>
		</div>

        <jet-validation-errors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

		<div class="socialLogin">
			<a href="/login/facebook">
				<c-btn
					class="mb-4"
					full
					color="facebook"
					icon="facebook"
				>{{ trans.choice('auth.login_with_facebook_btn', 1) }}</c-btn>
			</a>
			
			<a href="/login/google">
				<c-btn
					full
					outlined
				>
					<div class="flex items-center">
						<div class="googleIconContainer mr-4">
							<img src="/img/google_logo.svg" alt="Google logo">
						</div>
						<span>{{ trans.get('auth.login_with_google_btn') }}</span>
					</div>
				</c-btn>
			</a>
		</div>
		
		<div class="hr">{{ trans.get('auth.login_social_or_email') }}</div>
		
        <form @submit.prevent="submit">
            <div>
                <c-input name="email" type="email" :label="trans.get('auth.email_label')" v-model="form.email" required autofocus />
            </div>

            <div class="mt-4">
                <c-input :label="trans.get('auth.password_label')" name="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
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
	
	        <div class="authPopupActions flex justify-between">
		        <c-btn
			        text
			        @click="$root.openForgotPasswordPopup()"
		        >
			        {{ trans.get('auth.lost_password_btn') }}
		        </c-btn>
		        <c-btn
			        text
			        @click="$root.openRegistrationPopup()"
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
    import Logo from "../../Layouts/Partials/Logo";
    
    export default {
        components: {
	        Logo,
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
                    remember: false,
	                availability_id: null,
	                teacher_id: null,
                })
            }
        },

        methods: {
            submit() {
	            if (this.$root.registrationAddonData) {
		            this.form.teacher_id = this.$root.registrationAddonData.teacher_id;
		            this.form.availability_id = this.$root.registrationAddonData.availability_id;
	            }
        		
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post('/login', {
                        onFinish: () => {
	                        this.form.reset('password');
                        },
                        onSuccess: () => {
                            this.$root.hideLoginPopup();
	                        this.$toast.success('Bejelentkezve');
	                        this.$root.registrationAddonData = null;
                        },
                        onError: error => {
                        	console.error(error);
	                        this.$toast.error('Sikertelen bejelentkezés');
                        }
                    })
            }
        }
    }
</script>
