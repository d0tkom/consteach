<template>
    <div>
        <div>
            <div class="mt-4">
                <cInput
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Jelszó"
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
            >Mégsem</cBtn>

            <cBtn
                :loading="form.processing"
                @click="deleteUser"
            >Fiók törlése</cBtn>
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
	                    this.$toast.success('Sikeres törlés');
                    },
                    onError: () => {
                    	this.$refs.password.focus();
	                    this.$toast.error('Sikertelen törlés');
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
