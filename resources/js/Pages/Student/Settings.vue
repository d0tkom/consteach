<template>
    <app-layout>
        <div class="studentSettingsContainer">
            <!-- Felhasználói adatok -->
            <div class="page userSettings shadow-lg">
                <div class="top mb-4">
                    <div class="profileImg">
                        <img :src="$page.props.user.profile_photo_url" alt="Diák profilkép">
                        <c-input
                            type="file"
                            only-slot
                            class="profileImageEditIcon"
                        >
                            <c-btn
                                icon="edit"
                                icon-only
                                circle
                            ></c-btn>
                        </c-input>
                    </div>
                    <div class="userName title text-center color-primary text-2xl mt-4">{{ $page.propr.user.last_name }}</div>
                </div>
                <div class="content">
                    <form>
                        <h2 class="title text-lg color-primary-dark mb-4">{{ trans.get('dashboard.student') }}</h2>
                        <div class="mb-4">
                            <cInput
                                :error="$page.props.errors.first_name ? true : false"
                                v-model="form.first_name"
                                :label="trans.get('settings.first_name_label')"
                            ></cInput>
                        </div>
                        
                        <div class="mb-4">
                            <cInput
                                :error="$page.props.errors.last_name ? true : false"
                                :label="trans.get('settings.last_name_label')"
                                v-model="form.last_name"
                            ></cInput>
                        </div>
                        
                        <div class="mb-4">
                            <cInput
                                :error="$page.props.errors.email ? true : false"
                                :label="trans.get('settings.email_label')"
                                v-model="form.email"
                            ></cInput>
                        </div>
                        
                        <div
                            class="grid md:grid-cols-2 grid-cols-1 gap-4 mb-4"
                            v-for="(language, languageIndex) in form.spoken_languages"
                            :key="languageIndex"
                        >
                            <div>
                                <c-select
                                    :data="languageList"
                                    :label="trans.get('settings.spoken_language')"
                                    labelKey="name"
                                    valueKey="code"
                                    :selected="language.language"
                                    v-model="language.language"
                                />
                            </div>
                            
                            <div>
                                <c-select
                                    :data="levels"
                                    :label="trans.get('settings.language_level')"
                                    labelKey="label"
                                    valueKey="code"
                                    :selected="language.level"
                                    v-model="language.level"
                                />
                            </div>
                        </div>
                        
                        <c-btn
                            text
                            icon="add"
                            @click="addNewLanguage"
                        >
                            {{ trans.get('settings.add_language_btn') }}
                        </c-btn>

                        <update-password-form class="mt-10 sm:mt-0" />


                        <div class="formExtra mt-4 flex justify-between">
                            <c-btn
                                outlined
                                icon="change_circle"
                                @click="changePasswordPopup = true"
                            >
                                {{ trans.get('settings.change_password_btn') }}
                            </c-btn>
                            <c-btn
                                outlined
                                color="error"
                                icon="delete"
                                @click="removeAccountPopup = true"
                            >
                                {{ trans.get('settings.delete_account_btn') }}
                            </c-btn>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Beállítások -->
            <div class="page shadow-lg">
                <h2 class="title text-lg color-primary-dark mb-4">{{ trans.get('settings.website_settings') }}</h2>
                
                <c-select
                    class="mb-4"
                    :label="trans.get('settings.site_language')"
                    :data="languages"
                    label-key="name"
                    value-key="code"
                    :selected="form.site_language"
                    v-model="form.site_language"
                />
                <c-select
                    class="mb-4"
                    :label="trans.get('settings.currency')"
                    :data="currencies"
                    label-key="name"
                    value-key="code"
                    :selected="form.currency"
                    v-model="form.currency"
                />
                <c-select
                    class="mb-4"
                    :label="trans.get('settings.timezone')"
                    :data="timezones"
                    label-key="name"
                    value-key="code"
                    :selected="form.timezone"
                    v-model="form.timezone"
                />
            </div>
            
            <div class="actions flex justify-center mb-4">
                <c-btn
                    icon="save"
                    :loading="saving"
                    type="submit"
                    @click="submit"
                >
                    {{ trans.get('settings.save_btn') }}
                </c-btn>
            </div>
        
            <change-password v-model="changePasswordPopup"></change-password>
            <delete-profile v-model="removeAccountPopup"></delete-profile>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import countries from '@/Partials/countries'
    import languages from '@/Partials/languages'
    import currencies from '@/Partials/currencies'
    import timezones from '@/Partials/timezones'
    import levels from '@/Partials/levels'
    import ChangePassword from '@/Popups/ChangePassword'
    import DeleteProfile from "@/Popups/DeleteProfile"
    import UpdatePasswordForm from '@/Pages/Profile/UpdatePasswordForm'

    
    export default {
        components: {
            AppLayout,
            ChangePassword,
            DeleteProfile,
            UpdatePasswordForm,
        },
        data() {
            return {
                countries,
                languages,
                levels,
                languageList: null,
                currencies,
                timezones,
                locale: window.default_locale,
                
                saving: false,
                
                removeAccountPopup: false,
                changePasswordPopup: false,
                
                languageTemplate: {
                    language: null,
                    level: null
                },
                
                form: this.$inertia.form({
                    first_name: this.$page.props.user.first_name,
                    last_name: this.$page.props.user.last_name,
                    email: this.$page.props.user.email,
                    spoken_languages: this.$page.props.user.spoken_languages ?? [{language: null, level: null}],
                    site_language: this.$page.props.user.site_language,
                    currency: this.$page.props.user.currency,
                    timezone: this.$page.props.user.timezone,
                }, {
                    bag: 'updateUser',
                    resetOnSuccess: true,
                }),
            };
        },
        created() {
            this.countries = require('i18n-iso-countries');
            this.countries.registerLocale(require('i18n-iso-countries/langs/en.json'));
            this.countries.registerLocale(require('i18n-iso-countries/langs/hu.json'));
            this.countries.registerLocale(require('i18n-iso-countries/langs/de.json'));

            this.countries = Object.entries(this.countries.getNames(this.locale, {select: 'official'})).map(array => {
                return {code: array[0], name: array[1]};
            });

            this.languageList = require('@cospired/i18n-iso-languages');
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/en.json'));
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/hu.json'));
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/de.json'));

            this.languageList = Object.entries(this.languageList.getNames(this.locale, {select: 'official'})).map(array => {
                return {code: array[0], name: array[1]};
            });

            this.currencies = this.currencies.map(code => {
                return {code: code, name: code};
            });
        },
        methods: {
            addNewLanguage() {
                const languageTemplate = JSON.parse(JSON.stringify(this.languageTemplate));
                this.form.spoken_languages.push(languageTemplate);
            },
            save() {
                console.warn('TODO:Saving settings...');
                this.saving = true;
                
                setTimeout(() => {
                    this.saving = false;
                }, 2000);
            },
            submit() {
                this.form.put('/users/' + this.$page.props.user.id, { preserveScroll: true });
            }
        }
    }
</script>