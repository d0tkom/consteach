<template>
    <div>
        <div>
            <div class="mt-4">
                <cInput
                    type="password"
                    class="mt-1 block w-3/4"
                    :placeholder="trans.get('settings.delete_profile_password_placeholder')"
                    ref="remove-user-password"
                    v-model="form.password"
                    @keyup.enter="deleteUser"
                />
                <jet-input-error :message="form.errors.password" class="mt-2" />
            </div>
        </div>

        <div class="flex justify-between">
            <cBtn
                outlined
                @click="closeModal"
            >{{ trans.get('settings.delete_profile_cancel_btn') }}</cBtn>

            <cBtn
                :loading="form.processing"
                @click="deleteUser"
            >{{ trans.get('settings.delete_profile_submit_btn') }}</cBtn>
        </div>
    </div>
</template>

<script>
    import JetInputError from '@/Jetstream/InputError'

    export default {
        components: {
            JetInputError,
        },
        data() {
            return {
                confirmingUserDeletion: false,

                form: this.$inertia.form({
                    password: '',
                })
            }
        },

        methods: {
            confirmUserDeletion() {
                this.confirmingUserDeletion = true;

                setTimeout(() => this.$refs.password.focus(), 250)
            },
            deleteUser() {
                this.form.delete('/user', {
                    preserveScroll: true,
                    onSuccess: () => {
                    	this.closeModal();
                    	let message = this.trans.get('settings.delete_profile_submit_success_notification');
	                    this.$toast.success(message);
                    },
                    onError: () => {
                    	this.$refs.password.focus();
	                    let message = this.trans.get('settings.delete_profile_submit_fail_notification');
	                    this.$toast.error(message);
                    },
                    onFinish: () => this.form.reset(),
                })
            },
            closeModal() {
                this.confirmingUserDeletion = false
                this.form.reset()
                this.$emit('close');
            },
        },
    }
</script>
