<template>
    <div class="w-full max-w-sm">
        <form @submit.prevent="submit" class="rounded px-8 pt-6 pb-8 mb-6">
            <div class="mb-6">
                <label class="block text-sm font-bold mb-2" for="first_name">
                    First name:
                </label>
                <jet-input class="w-full" id="first_name" v-model="form.first_name" @input="$page.props.errors.first_name = null" />
                <p class="text-red-500 text-xs italic" v-if="$page.props.errors.first_name">{{ $page.props.errors.first_name }}</p>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-bold mb-2" for="last_name">
                    Last name:
                </label>
                <jet-input class="w-full" id="last_name" v-model="form.last_name" @input="$page.props.errors.last_name = null" />
                <p class="text-red-500 text-xs italic" v-if="$page.props.errors.last_name">{{ $page.props.errors.last_name }}</p>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-bold mb-2" for="email">
                    Email:
                </label>
                <jet-input class="w-full" id="email" v-model="form.email" @input="$page.props.errors.email = null" />
                <p class="text-red-500 text-xs italic" v-if="$page.props.errors.email">{{ $page.props.errors.email }}</p>
            </div>
            <div class="w-full mb-6">
                <label class="block text-sm font-bold mb-2" for="country">
                    Country:
                </label>
                <div class="relative">
                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="country">
                        <option v-for="(name, code) in countries.getNames(locale, {select: 'official'})" :value="code" :selected="code == form.country">{{name}}</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
            <jet-button type="submit">Submit</jet-button>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>
            <jet-button :class="{ 'btn-blue': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </form>
    </div>
</template>

<script>
    import JetApplicationLogo from './../../Jetstream/ApplicationLogo'
    import JetActionMessage from './../../Jetstream/ActionMessage'
    import JetInput from './../../Jetstream/Input'
    import JetButton from './../../Jetstream/Button'

    export default {
        components: {
            JetApplicationLogo,
            JetInput,
            JetButton,
            JetActionMessage,
        },
        data() {
            return {
                countries: null,
                locale: window.default_locale,
                form: this.$inertia.form({
                    first_name: this.$page.props.user.first_name,
                    last_name: this.$page.props.user.last_name,
                    email: this.$page.props.user.email,
                    country: this.$page.props.user.country,
                }, {
                    bag: 'updateUser',
                    resetOnSuccess: true,
                }),
            }
        },
        created() {
            this.countries =  require("i18n-iso-countries");
            this.countries.registerLocale(require("i18n-iso-countries/langs/en.json"));
            this.countries.registerLocale(require("i18n-iso-countries/langs/hu.json"));
            this.countries.registerLocale(require("i18n-iso-countries/langs/de.json"));
        },
        methods: {
            submit() {
                this.form.put('/users/' + this.$page.props.user.id, { preserveScroll: true });
            },
        }
    }
</script>