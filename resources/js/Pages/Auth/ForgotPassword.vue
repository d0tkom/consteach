<template>
	<div class="slideoutContent p-6">
		<c-btn
			class="slideoutCloseBtn"
			icon="close"
			icon-only
			text
			circle
			@click="$root.hideForgotPasswordPopup()"
		></c-btn>

		<div class="flex justify-center my-4 mb-8">
			<logo
				class="brandLogo"
				:width="200"
				:height="60"
			/>
		</div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
	            <c-input
		            :label="trans.get('auth.email_label')"
		            id="email"
		            type="email"
		            v-model="form.email"
		            required
		            autofocus
		            autocomplete="email"
	            />
            </div>

            <div class="flex items-center justify-end mt-4">
                <c-btn
	                @click="submit"
	                :loading="form.processing">
                    {{ trans.get('auth.password_reset_link_btn') }}
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
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import Logo from "../../Layouts/Partials/Logo";

    export default {
        components: {
	        Logo,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetLabel,
            JetValidationErrors
        },

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: ''
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.email'));
            }
        }
    }
</script>
