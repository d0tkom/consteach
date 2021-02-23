<template>
    <app-layout>
        <div class="studentSettingsContainer">
            <!-- Felhasználói adatok -->
            <div class="card md userSettings">
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
                    <div class="userName title text-center color-primary text-2xl mt-4">András</div>
                </div>
                <div class="content">
                    <form>
                        <h2 class="title text-lg color-primary-dark mb-4">Felhasználói adatok</h2>
                        <div class="mb-4">
                            <cInput
                                v-model="form.first_name"
                                :error="!!$page.props.errors.first_name"
                                label="Keresztnév"
                            ></cInput>
                        </div>
                        
                        <div class="mb-4">
                            <cInput
                                :error="!!$page.props.errors.first_name"
                                label="Családnév"
                                v-model="form.last_name"
                            ></cInput>
                        </div>
                        
                        <div class="mb-4">
                            <cInput
                                label="Email cím"
                                :error="!!$page.props.errors.email"
                                v-model="form.email"
                            ></cInput>
                        </div>

                        <div class="mb-4">
                            <c-select
                                :data="countries"
                                label="Származási hely"
                                labelKey="name"
                                valueKey="code"
                                :selected="form.country"
                                v-model="form.country"
                            />
                        </div>
                        
                        <!-- Tanított nyelvek -->
                        <div class="mb-4">
                            <div
                                class="grid md:grid-cols-2 grid-cols-1 gap-4 mb-4"
                                v-for="(language, languageIndex) in form.teaching_languages"
                                :key="languageIndex"
                            >
                                <div>
                                    <c-select
                                        :data="languageList"
                                        label="Tanított nyelv"
                                        labelKey="name"
                                        valueKey="code"
                                        :selected="language.language"
                                        v-model="language.language"
                                    />
                                </div>
                                
                                <div>
                                    <c-select
                                        :data="levels"
                                        label="Szint"
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
                                @click="addNewTeachingLanguage"
                            >
                                Nyelv hozzáadása
                            </c-btn>
                        </div>
                        
                        <hr class="mb-4" />
                        
                        <!-- Beszélt nyelvek -->
                        <div>
                            <div
                                class="grid md:grid-cols-2 grid-cols-1 gap-4 mb-4"
                                v-for="(language, languageIndex) in form.spoken_languages"
                                :key="'ltn-'+ languageIndex"
                            >
                                <div>
                                    <c-select
                                        :data="languageList"
                                        label="Beszélt nyelv"
                                        labelKey="name"
                                        valueKey="code"
                                        :selected="language.language"
                                        v-model="language.language"
                                    />
                                </div>
                                
                                <div>
                                    <c-select
                                        :data="levels"
                                        label="Szint"
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
                                @click="addNewSpokenLanguage"
                            >
                                Nyelv hozzáadása
                            </c-btn>
                        </div>
                        
                        <div class="formExtra mt-4 flex justify-between">
                            <c-btn
                                outlined
                                icon="change_circle"
                                @click="changePasswordPopup = true"
                            >
                                Jelszó változtatása
                            </c-btn>
                            <c-btn
                                outlined
                                color="error"
                                icon="delete"
                                @click="removeAccountPopup = true"
                            >
                                Fiók törlése
                            </c-btn>
                        </div>
                    </form>
                </div>
            </div>

            <div
                class="card md"
                v-for="(about_me, a) in form.about_me"
                :key="'abtm-'+ a"
            >
                    <div>
                        <h2 class="title text-lg color-primary-dark mb-4">Bemutatkozás {{ about_me.locale }}</h2>
                        <c-text-area
                            hint="Minimum 250 karakter"
                            :max="2000"
                            v-model="about_me.text"
                        />
                    </div>

                </div>
            </div>
        
            <div class="card md">
                <h2 class="title text-lg color-primary-dark mb-4">Videó</h2>
                <c-input
                    class="mb-2"
                    type="text"
                    v-model="form.video_url"
                    :error="!!$page.props.errors.video_url"
                    label="Youtube link"
                />
                <iframe width="100%" height="315" :src="form.video_url.replace('watch?v=', 'embed/')" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        
            <div class="card md">
                <h2 class="title text-lg color-primary-dark mb-4">Óradíjak</h2>
                <c-slider
                    class="mb-2"
                    label="1 óra"
                    v-model="form.one_hour_price"
                    :max="200000"
                />
                <c-slider
                    class="mb-2"
                    label="5 óra"
                    v-model="form.five_hour_price"
                    :max="200000"
                />
                <c-slider
                    class="mb-2"
                    label="10 óra"
                    v-model="form.ten_hour_price"
                    :max="200000"
                />
            </div>
            
            <!-- Beállítások -->
            <div class="card md">
                <h2 class="title text-lg color-primary-dark mb-4">Weboldal beállítások</h2>

                <c-select
                    class="mb-4"
                    label="Oldal nyelve"
                    :data="languages"
                    label-key="name"
                    value-key="code"
                    :selected="form.site_language"
                    v-model="form.site_language"
                />
                <c-select
                    class="mb-4"
                    label="Pénznem"
                    :data="currencies"
                    label-key="name"
                    value-key="code"
                    :selected="form.currency"
                    v-model="form.currency"
                />

                <c-select
                    class="mb-4"
                    label="Időzóna"
                    :data="timezones"
                    label-key="name"
                    value-key="code"
                    :selected="form.timezone"
                    v-model="form.timezone"
                />
            </div>
            
            <div class="actions flex justify-center mb-4">
                <c-btn
                    type="submit"
                    @click="submit"
                    icon="save"
                    :loading="saving"
                >
                    Változtatások mentése
                </c-btn>
            </div>
        
            <change-password v-model="changePasswordPopup" />
            <delete-profile v-model="removeAccountPopup" />
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
    import DeleteProfile from "@/Popups/DeleteProfile";
    
    export default {
        components: {
            ChangePassword,
            DeleteProfile,
            AppLayout,
        },
        props: {
            teacher: Object
        },
        data() {
            return {
                countries,
                languages,
                languageList: null,
                currencies,
                timezones,
                levels,
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
                    country: this.$page.props.user.country,
                    spoken_languages: this.$page.props.user.spoken_languages ?? [{language: null, level: null}],
                    teaching_languages: this.teacher.teaching_languages ?? [{language: null, level: null}],
                    site_language: this.$page.props.user.site_language,
                    currency: this.$page.props.user.currency,
                    timezone: this.$page.props.user.timezone,
                    about_me: this.teacher.about_me ?? [{locale: 'hu', text: ''}, {locale: 'en', text: ''}],
                    video_url: this.teacher.video_url,
                    one_hour_price: this.teacher.one_hour_price,
                    five_hour_price: this.teacher.five_hour_price,
                    ten_hour_price: this.teacher.ten_hour_price,
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
            addNewSpokenLanguage() {
                const languageTemplate = JSON.parse(JSON.stringify(this.languageTemplate));
                this.form.spoken_languages.push(languageTemplate);
            },
            addNewTeachingLanguage() {
                const languageTemplate = JSON.parse(JSON.stringify(this.languageTemplate));
                this.form.teaching_languages.push(languageTemplate);
            },
            submit() {
                this.form.put('/users/' + this.$page.props.user.id, { preserveScroll: true });
            },
        }
    }
</script>