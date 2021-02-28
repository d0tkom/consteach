<template>
	<div>
        <jet-validation-errors class="mb-4" />
		
		<div class="roleSelect grid grid-cols-2 gap-4 mb-8">
			<c-btn
				full
				:outlined="form.teacher"
				@click="form.teacher = false"
			>Regisztráció diákként</c-btn>
			<c-btn
				full
				:outlined="!form.teacher"
				@click="form.teacher = true"
			>Regisztráció tanárként</c-btn>
		</div>
		
		<div class="socialLogin">
			<c-btn
				class="mb-4"
				full
				color="facebook"
				icon="facebook"
				:navigate-to="'/login/facebook/?user_role=' + form.teacher ? 'student' : 'teacher'"
			>{{ trans.get('auth.login_with_facebook_btn') }}</c-btn>
			
			<c-btn
				full
				outlined
				:navigate-to="'/login/google/?user_role=' + form.teacher ? 'student' : 'teacher'"
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
            <div class="grid grid-cols-2 gap-4 mb-4">
                <c-input
	                :label="trans.get('auth.first_name_label')"
	                id="first_name"
	                type="text"
	                v-model="form.first_name"
	                required
	                autofocus
	                autocomplete="first_name"
                />
	
	            <c-input
		            :label="trans.get('auth.last_name_label')"
		            id="last_name"
		            type="text"
		            v-model="form.last_name"
		            required
		            autocomplete="last_name"
	            />
            </div>

            <div class="mb-4">
	            <c-input
		            :label="trans.get('auth.email_label')"
		            id="registration_email"
		            type="email"
		            v-model="form.email"
		            required
		            autocomplete="email"
	            />
            </div>
	
	        <div class="grid grid-cols-2 gap-4 mb-4">
	            <c-input
		            :label="trans.get('auth.password_label')"
		            id="registration_password"
		            type="password"
		            v-model="form.password"
		            required
		            autocomplete="password"
	            />
		        <c-input
			        :label="trans.get('auth.password_confirmation_label')"
			        id="registration_password_confirmation"
			        type="password"
			        v-model="form.password_confirmation"
			        required
			        autocomplete="password_confirmation"
		        />
            </div>

            <div class="mb-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <jet-label for="terms">
                    <div class="flex items-center">
                        <jet-checkbox name="terms" id="terms" v-model:checked="form.terms" />

                        <div class="ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                        </div>
                    </div>
                </jet-label>
            </div>

            <div class="flex items-center justify-center my-4">
                <c-btn
	                :loading="form.processing"
	                @click="submit"
                >
	                {{ trans.get('auth.register_btn') }}
                </c-btn>
            </div>
	        
	        <div class="flex justify-end">
		        <c-btn
			        text
			        navigate-to="/#login"
			    >
			        {{ trans.get('auth.already_registered_btn') }}
		        </c-btn>
	        </div>
        </form>
    </div>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from "@/Jetstream/Checkbox";
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },

        data() {
            return {
                form: this.$inertia.form({
	                teacher: false,
                    first_name: '',
                    last_name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
	                onFinish: () => {
		                this.form.reset('password', 'password_confirmation');
		                this.$emit('close');
	                }
                })
            }
        }
    }
</script>
