<template>
    <app-layout>
        <div class="studentSettingsContainer">
            <!-- Felhasználói adatok -->
            <div class="page userSettings shadow-lg">
                <div class="top mb-4">
                    <div class="profileImg">
                        <img v-if="!photoPreview" :src="$page.props.user.profile_photo_url" alt="Diák profilkép">
                        <img v-else :src="photoPreview" alt="Diák profilkép">
                        <div class="inputContainer profileImageEditIcon">
                            <label>
                                <input
                                    id="photo-input"
                                    ref="photo"
                                    class="hidden"
                                    type="file"
                                    @change="updatePhotoPreview"
                                >
                                <c-btn
                                    icon="edit"
                                    icon-only
                                    circle
                                ></c-btn>
                            </label>
                        </div>
                    </div>

                    <div class="userName title text-center color-primary text-2xl mt-4">{{ $page.props.user.first_name }}</div>
                </div>
                <div class="content">
                    <form>
                        <h2 class="title text-lg color-primary-dark mb-4">{{ trans.get('settings.student') }}</h2>
                        <div class="mb-4">
                            <cInput
                                :error="!!form.errors.first_name"
                                v-model="form.first_name"
                                :label="trans.get('settings.first_name_label')"
                            ></cInput>
                        </div>
                        
                        <div class="mb-4">
                            <cInput
                                :error="!!form.errors.last_name"
                                :label="trans.get('settings.last_name_label')"
                                v-model="form.last_name"
                            ></cInput>
                        </div>
                        
                        <div class="mb-4">
                            <cInput
                                :error="!!form.errors.email"
                                :label="trans.get('settings.email_label')"
                                v-model="form.email"
                            ></cInput>
                        </div>

                        <div class="formExtra mt-4 flex justify-between">
                            <c-btn
                                outlined
                                icon="change_circle"
                                @click="changePasswordPopup = true"
                            >
                                {{ trans.get('settings.change_password_btn') }}
                            </c-btn>
                            <!-- <c-btn
                                outlined
                                color="error"
                                icon="delete"
                                @click="removeAccountPopup = true"
                            >
                                {{ trans.get('settings.delete_account_btn') }}
                            </c-btn> -->
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Beállítások -->
            <div class="page shadow-lg">
                <h2 class="title text-lg color-primary-dark mb-4">{{ trans.get('settings.website_settings') }}</h2>
                
                <c-select
	                capitalize
                    class="mb-4"
                    :label="trans.get('settings.site_language')"
                    :data="languages"
                    label-key="name"
                    value-key="code"
	                :error="!!form.errors.site_language"
                    :selected="form.site_language"
                    v-model="form.site_language"
                />
                <c-select
                    class="mb-4"
                    :label="trans.get('settings.currency')"
                    :data="currencies"
                    label-key="name"
                    value-key="code"
                    :error="!!form.errors.currency"
                    :selected="form.currency"
                    v-model="form.currency"
                />
                <c-select
                    class="mb-4"
                    :label="trans.get('settings.timezone')"
                    :data="timezones"
                    label-key="name"
                    value-key="code"
                    :error="!!form.errors.timezone"
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
        props: {
            timezoneList: Array,
        },
        data() {
            return {
                countries,
                languages,
                levels,
                timezones: [],
                currencies,

                locale: window.default_locale,

                photoPreview: null,
                
                saving: false,
                
                removeAccountPopup: false,
                changePasswordPopup: false,
                
                form: this.$inertia.form({
                    '_method': 'PUT',
                    photo: null,
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
	    mounted() {
		    let title = this.trans.get('settings.document_title');
		    this.$root.documentTitle(title);
	    },
        created() {
        	if (location.hash === '#updated') {
        		this.showUserUpdateNotification();
        		this.$inertia.replace('/settings');
	        }
        	
            this.countries = require('i18n-iso-countries');
            this.countries.registerLocale(require('i18n-iso-countries/langs/en.json'));
            this.countries.registerLocale(require('i18n-iso-countries/langs/hu.json'));
            this.countries.registerLocale(require('i18n-iso-countries/langs/de.json'));

            this.countries = Object.entries(this.countries.getNames(this.locale, {select: 'official'})).map(array => {
                return {code: array[0], name: array[1]};
            });
	
	        this.countries.sort(this.$root.sortAlphabetByName);
	
	
	        this.timezones =  this.$page.props.timezoneList.map(value => {
                return {code: value, name: value};
            });

            this.currencies = this.currencies.map(code => {
                return {code: code, name: code};
            });
        },
        methods: {
	        removeHash() {
			    history.pushState(null, document.title, window.location.pathname + window.location.search);
		    },
	        showUserUpdateNotification() {
		        this.$toast.success(this.trans.get('settings.updated_success_notification'));
	        },
            submit() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0];
                }
                
                this.form.post('/users/' + this.$page.props.user.id, {
                	preserveScroll: true,
	                onSuccess: () => {
		                this.$toast.success(this.trans.get('settings.updated_success_notification'));
	                },
	                onError: error => {
                		console.error(error);
		                this.$toast.error(this.trans.get('settings.updated_fail_notification'));
	                }
                });
            },
            updatePhotoPreview() {
                const reader = new FileReader();
        
                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },
        }
    }
</script>