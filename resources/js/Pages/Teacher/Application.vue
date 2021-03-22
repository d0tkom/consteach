<template>
	<app-layout>
		<div class="card md flat teacherApplicationContainer">
			<div class="tabs p-4 mb-4 bg-white rounded-xl shadow-md border blue-border items-center relative">
				<div class="tabsContainer flex text-center blue-text-color">
					<div
						v-for="tab in tabs"
						:key="tab.id"
						class="tabItem flex-1"
						:class="activeTab > tab.id && 'past'"
					>
						<div
							class="tabNumber h-10 m-auto rounded-full w-10 border blue-border-color text-center text-2xl flex flex-col justify-center mb-2"
							:class="{activeTab: activeTab === tab.id}"
						>{{ tab.id + 1 }}</div>
						<div class="tabLabel">{{ tab.label }}</div>
					</div>
				</div>
			</div>
			<div v-if="activeTab === 0">
				<div class="card mb-4">
					<h2 class="title text-lg color-primary-dark mb-4 font-bold">
						{{ trans.get('teacher_application.user_informations') }}
					</h2>
					<div class="content">
						<form>
							<div class="mb-4">
								<cInput
									v-model="form.first_name"
									:label="trans.get('teacher_application.first_name_label')"
									:error="!!$page.props.errors.first_name"
								></cInput>
							</div>
							
							<div class="mb-4">
								<cInput
									:label="trans.get('teacher_application.last_name_label')"
									v-model="form.last_name"
									:error="!!$page.props.errors.last_name"
								></cInput>
							</div>
							
							<div class="mb-4">
								<cInput
									readonly
									:label="trans.get('teacher_application.email_label')"
									v-model="form.email"
									:error="!!$page.props.errors.email"
								></cInput>
							</div>
							
							<div class="mb-4">
								<c-select
									capitalize
									:data="countries"
									:label="trans.get('teacher_application.country_label')"
									labelKey="name"
									valueKey="code"
									:error="!!$page.props.errors.country"
									v-model="form.country"
								/>
							</div>
							
							<div class="mb-4">
								<c-select
									class="mb-4"
									:label="trans.get('teacher_application.timezone_label')"
									:data="timezones"
									label-key="name"
									value-key="code"
									:error="!!$page.props.errors.timezone"
									:selected="form.timezone"
									v-model="form.timezone"
								/>
							</div>
							
							<!-- Tanított nyelvek -->
							<div class="mb-4">
								<div
									class="title color-gray mb-2"
									:class="!!$page.props.errors.teaching_languages && 'text-red-500'"
								>{{ trans.get('teacher_application.teaching_language') }}</div>
								<div
									class="grid md:grid-cols-2 grid-cols-1 gap-4 mb-4"
									v-for="(language, languageIndex) in form.teaching_languages"
									:key="languageIndex"
								>
									<div>
										<c-select
											capitalize
											:data="languageList"
											:label="trans.get('teacher_application.language_label')"
											labelKey="name"
											valueKey="code"
											:error="!!$page.props.errors.teaching_languages"
											v-model="language.language"
										/>
									</div>
									
									<div>
										<c-select
											:data="levels"
											:label="trans.get('teacher_application.level_label')"
											labelKey="label"
											valueKey="code"
											:error="!!$page.props.errors.teaching_languages"
											v-model="language.level"
										/>
									</div>
								</div>
								<c-btn
									text
									icon="add"
									@click="addNewTeachingLanguage"
								>
									{{ trans.get('teacher_application.add_language_btn') }}
								</c-btn>
							</div>
							
							<hr class="mb-4" />
							
							<!-- Beszélt nyelvek -->
							<div>
								<div
									class="title color-gray mb-2"
									:class="!!$page.props.errors.spoken_languages && 'text-red-500'"
								>{{ trans.get('teacher_application.spoken_language') }}</div>
								<div
									class="grid md:grid-cols-2 grid-cols-1 gap-4 mb-4"
									v-for="(language, languageIndex) in form.spoken_languages"
									:key="'ltn-'+languageIndex"
								>
									<div>
										<c-select
											capitalize
											:data="languageList"
											:label="trans.get('teacher_application.language_label')"
											labelKey="name"
											valueKey="code"
											:error="!!$page.props.errors.spoken_languages"
											v-model="language.language"
										/>
									</div>
									
									<div>
										<c-select
											:data="levels"
											:label="trans.get('teacher_application.level_label')"
											labelKey="label"
											valueKey="code"
											:error="!!$page.props.errors.spoken_languages"
											v-model="language.level"
										/>
									</div>
								</div>
								
								<c-btn
									text
									icon="add"
									@click="addNewSpokenLanguage"
								>
									{{ trans.get('teacher_application.add_language_btn') }}
								</c-btn>
							</div>
							
							<c-checkbox
								class="my-2"
								v-model="form.adult"
								:error="!!$page.props.errors.adult"
							>{{ trans.get('teacher_application.adult_checkbox_label') }}</c-checkbox>
						</form>
					</div>
				</div>
				<div class="card md">
					<!-- Óradíjak -->
					<h2
						class="title text-lg font-bold color-primary-dark mb-4 flex"
					>
						{{ trans.get('teacher_application.hourly_rates') }}
						<span
							class="material-icons cursor-help ml-4"
							v-tooltip="trans.get('teacher_application.hourly_rates_tooltip')"
						>help_outline</span>
					</h2>
					<div class="grid grid-cols-2 gap-4">
						<c-input
							:label="trans.get('teacher_application.one_hour_net')"
							v-model="form.one_hour_price"
						/>
						<c-input
							readonly
							:label="trans.get('teacher_application.one_hour_gross')"
							:value="calculateGrossPrice(form.one_hour_price)"
						/>
					</div>
					<h2
						class="title text-lg font-bold color-primary-dark mt-8 mb-4 flex"
					>
						{{ trans.get('teacher_application.bulk_prices') }}
						<span
							class="material-icons cursor-help ml-4"
							v-tooltip="trans.get('teacher_application.bulk_prices_tooltip')"
						>help_outline</span>
					</h2>
					<div class="grid grid-cols-2 gap-4 mb-4">
						<c-input
							:hint="'/'+trans.get('teacher_application.hour')"
							:label="trans.get('teacher_application.five_hours_net')"
							:value="calculateHourPrice(form.five_hour_price, 5, true)"
							@keyup="value => bulkPriceInput(value, 'five_hour_price', 5, true)"
						/>
						<c-input
							:hint="'/'+trans.get('teacher_application.hour')"
							readonly
							:label="trans.get('teacher_application.five_hours_gross')"
							:value="calculateHourPrice(form.five_hour_price, 5, false)"
						/>
					</div>
					<div class="grid grid-cols-2 gap-4">
						<c-input
							:hint="'/'+trans.get('teacher_application.hour')"
							:label="trans.get('teacher_application.ten_hours_net')"
							:value="calculateHourPrice(form.ten_hour_price, 10, true)"
							@keyup="value => bulkPriceInput(value, 'ten_hour_price', 10, true)"
						/>
						<c-input
							:hint="'/'+trans.get('teacher_application.hour')"
							readonly
							:label="trans.get('teacher_application.ten_hours_gross')"
							:value="calculateHourPrice(form.ten_hour_price, 10, false)"
						/>
					</div>
				</div>
			</div>
			<div class="card" v-if="activeTab === 1">
				<div class="sm:flex">
					<div class="sm:w-7/12 w-full mr-8">
						<h2 class="title text-lg color-primary-dark mb-4 font-bold">{{ trans.get('teacher_application.profile_picture_title') }}</h2>
						<p class="mb-3 text-md">
							{{ trans.get('teacher_application.profile_picture_instruction') }}
						</p>
						<div class="flex items-center mb-4">
							<div class="profileImg">
		                        <img v-if="!profilePhotoPreview" :src="$page.props.user.profile_photo_url" alt="Tanár profilkép">
		                        <img v-else :src="profilePhotoPreview" alt="Tanár profilkép">
		                        <div class="inputContainer profileImageEditIcon">
		                            <label>
		                                <input
		                                    id="profile-photo-input"
		                                    ref="profile_photo"
		                                    class="hidden"
		                                    type="file"
		                                    @change="updateProfilePhotoPreview"
		                                >
		                                <c-btn
			                                :color="!!$page.props.errors.photo ? 'error' : 'primary'"
		                                    icon="edit"
		                                    icon-only
		                                    circle
		                                ></c-btn>
		                            </label>
		                        </div>
		                    </div>
							<span class="text-xs text-gray-500 ml-4">
								{{ trans.get('teacher_application.formats') }}
								<br/>Max.: 5MB</span>
						</div>
						<div class="text-center">
							<img class="block mb-2 w-full" src="/img/profile_img_test.jpg" alt="Man">
							<span class="text-gray-500 text-xs">{{ trans.get('teacher_application.profile_picture_example') }}</span>
						</div>
					</div>
					<div class="sm:w-5/12 w-full">
						<span class="block text-md font-semibold mb-6">{{ trans.get('teacher_application.profile_picture_tips') }}</span>
						<div class="flex mb-5">
							<img class="block mx-auto h-20 sm:h-16 rounded-full m-auto" src="/img/profile_photo_tip_1.png" alt="Woman's Face">
							<img class="block mx-auto h-20 sm:h-16 rounded-full m-auto" src="/img/profile_photo_tip_2.png" alt="Woman's Face">
							<img class="block mx-auto h-20 sm:h-16 rounded-full m-auto" src="/img/profile_photo_tip_3.png" alt="Woman's Face">
						</div>

						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">{{ trans.get('teacher_application.pp_tip_1') }}</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">{{ trans.get('teacher_application.pp_tip_2') }}</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">{{ trans.get('teacher_application.pp_tip_3') }}</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">{{ trans.get('teacher_application.pp_tip_4') }}</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">{{ trans.get('teacher_application.pp_tip_5') }}</span>
						</div>
					</div>
				</div>
			</div>
			<div class="card" v-if="activeTab === 2">
				<div class="sm:flex">
					<div class="sm:w-7/12 w-full mr-8">
						<h2 class="title text-lg color-primary-dark mb-4 font-bold">{{ trans.get('teacher_application.video_title') }}</h2>
						<p class="mb-3 text-md">
							{{ trans.get('teacher_application.video_instruction') }}
						</p>
						<div class="flex flex-col mb-4">
							<c-input
								class="mb-2"
								type="text"
								v-model="form.video_url"
								:error="!!$page.props.errors.video_url"
								:label="trans.get('teacher_application.youtube_link_label')"
							/>
							<iframe
								v-if="form.video_url"
								width="100%"
								height="200"
								:src="videoUrl"
								frameborder="0"
								allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
								allowfullscreen
							></iframe>
						</div>
					</div>
					<div class="sm:w-5/12 w-full">
						<span class="block text-md font-semibold mb-6">{{ trans.get('teacher_application.video_tips') }}</span>
						<div class="flex mb-5">
							<img
								class="block mx-auto h-20 sm:h-16 rounded-full m-auto"
								src="/img/profile_photo_tip_1.png"
								alt="Woman's Face"
							>
							<img
								class="block mx-auto h-20 sm:h-16 rounded-full m-auto"
								src="/img/profile_photo_tip_2.png"
								alt="Woman's Face"
							>
							<img
								class="block mx-auto h-20 sm:h-16 rounded-full m-auto"
								src="/img/profile_photo_tip_3.png"
								alt="Woman's Face"
							>
						</div>

						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">{{ trans.get('teacher_application.video_tip_1') }}</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">{{ trans.get('teacher_application.video_tip_2') }}</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">{{ trans.get('teacher_application.video_tip_3') }}</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">{{ trans.get('teacher_application.video_tip_4') }}</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">{{ trans.get('teacher_application.video_tip_5') }}</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">{{ trans.get('teacher_application.video_tip_6') }}</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">{{ trans.get('teacher_application.video_tip_7') }}</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">{{ trans.get('teacher_application.video_tip_8') }}</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">{{ trans.get('teacher_application.video_tip_9') }}</span>
						</div>
					</div>
				</div>
			</div>
			<div class="card" v-if="activeTab === 3">
				<h2 class="title text-lg color-primary-dark font-bold">{{ trans.get('teacher_application.about_me_title') }}</h2>
				<div class="color-blue-dark mb-4">{{ trans.get('teacher_application.about_me_instruction') }}</div>
				<div
	                class="card flat md-4"
	                v-for="(about_me, a) in form.about_me"
	                :key="'abtm-'+ a"
	            >
                    <div>
                        <h2 class="title text-lg color-primary-dark mb-4">{{ trans.get('teacher_application.about_me') }} <span class="capitalize">{{ $root.languageList[about_me.locale] }}</span></h2>
                        <c-text-area
                            :hint="trans.get('teacher_application.min_character', {num: 250})"
                            :max="2000"
                            class="mb-4"
                            :error="!!$page.props.errors.about_me"
                            v-model="about_me.text"
                        />
                    </div>
                </div>
            </div>
			<div class="card" v-if="activeTab === 4">
				<h2 class="title text-lg color-primary-dark font-bold">
					{{ trans.get('teacher_application.verification_title') }}
				</h2>
				<p>
					{{ trans.get('teacher_application.verification_instruction') }}
				</p>
				<div class="profileImg">
                    <img
	                    v-if="!verificationPhotoPreview"
	                    :src="$page.props.user.profile_photo_url"
	                    alt="Tanár profilkép"
                    >
                    <img
	                    v-else
	                    :src="verificationPhotoPreview"
	                    alt="Tanár profilkép"
                    >
                    <div class="inputContainer profileImageEditIcon alignCenter">
                        <label>
                            <input
                                id="verification-photo-input"
                                ref="verification_photo"
                                class="hidden"
                                type="file"
                                @change="updateVerificationPhotoPreview"
                            >
                            <c-btn
                                icon="edit"
                                icon-only
                                circle
                                :color="!!$page.props.errors.photo ? 'error' : 'primary'"
                            ></c-btn>
                        </label>
                    </div>
                </div>
			</div>
			<div class="actions flex justify-center">
				<c-btn
					:loading="form.processing"
					class="mr-2"
					v-show="activeTab > 0 && !form.processing"
					@click="prevTab"
					icon="keyboard_arrow_left"
				>{{ trans.get('teacher_application.back_btn') }}</c-btn>
				<c-btn
					v-if="activeTab !== tabs.length"
					:loading="form.processing"
					class="ml-2"
					@click="nextTab"
					icon-right="keyboard_arrow_right"
				>{{ trans.get('teacher_application.next_btn') }}</c-btn>
				<c-btn
					v-if="activeTab === tabs.length"
					:loading="form.processing"
					class="ml-2"
					@click="submit"
					icon="done"
				>{{ trans.get('teacher_application.submit_btn') }}</c-btn>
			</div>
		</div>
	</app-layout>
</template>

<script>
	import AppLayout from "@/Layouts/AppLayout";
	import languages from '@/Partials/languages'
	import currencies from '@/Partials/currencies'
	import levels from '@/Partials/levels'
	import getVideoId from 'get-video-id';
	
export default {
	components: {
		AppLayout,
	},
	props: {
		timezoneList: Array,
		teacher: Object,
	},
	data() {
		return {
			countries: null,
			languages,
			languageList: null,
			currencies,
			timezones: [],
			levels,
			locale: window.default_locale,
			fee: 1.2,
			languageTemplate: {
				language: null,
				level: null
			},

			profilePhotoPreview: null,
			verificationPhotoPreview: null,
			
			activeTab: 0,
			tabs: [
				{
					label: this.trans.get('teacher_application.tab_1_label'),
					id: 0,
				}, {
					label: this.trans.get('teacher_application.tab_2_label'),
					id: 1,
				}, {
					label: this.trans.get('teacher_application.tab_3_label'),
					id: 2,
				}, {
					label: this.trans.get('teacher_application.tab_4_label'),
					id: 3,
				},
			],
			form: this.$inertia.form({
				'_method': 'PUT',
	            photo: null,
	            verification_photo: null,
				first_name: this.$page.props.user.first_name,
				last_name: this.$page.props.user.last_name,
				email: this.$page.props.user.email,
				country: null,
				complete: true,
				timezone: null,
				about_me: [{locale: 'hu', text: ''}, {locale: 'en', text: ''}],
				video_url: null,
				step: 0,
				profile_photo: null,
				teaching_languages: [],
				spoken_languages: [],
				adult: false,
				one_hour_price: 0,
				five_hour_price: 0,
				ten_hour_price: 0,
			}),
		};
	},
	mounted() {
		const local_data = localStorage.getItem('teacher-application');
		if (local_data) {
			this.form = this.$inertia.form(JSON.parse(local_data));
		}
	},
	created() {
		this.countries = require('i18n-iso-countries');
		this.countries.registerLocale(require('i18n-iso-countries/langs/en.json'));
		this.countries.registerLocale(require('i18n-iso-countries/langs/hu.json'));
		this.countries.registerLocale(require('i18n-iso-countries/langs/de.json'));
		
		this.countries = Object.entries(this.countries.getNames(this.locale, {select: 'official'})).map(array => {
			return {code: array[0], name: array[1]};
		});

		this.countries.sort(this.$root.sortAlphabetByName);

		this.timezones = this.$page.props.timezoneList.map(value => {
            return {code: value, name: value};
        });

        this.timezones.sort(this.$root.sortAlphabetByName);
		
		this.languageList = require('@cospired/i18n-iso-languages');
		this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/en.json'));
		this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/hu.json'));
		this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/de.json'));
		
		this.languageList = Object.entries(this.languageList.getNames(this.locale, {select: 'official'})).map(array => {
			return {code: array[0], name: array[1]};
		});

		this.languageList.sort(this.$root.sortAlphabetByName);
		
		this.currencies = this.currencies.map(code => {
			return {code: code, name: code};
		});
	},
	watch: {
		form: {
			handler(form) {
				localStorage.setItem('teacher-application', JSON.stringify(form));
			},
			deep: true
		}
	},
	computed: {
		videoUrl() {
            return 'https://www.youtube.com/embed/' + getVideoId(this.form.video_url).id;
        }
	},
	methods: {
		bulkPriceInput(value, form_item, hours = 1, net = true) {
			value = parseInt(value, 10);
			
			let valueCalculated = value * hours;
			
			if (!net) {
				valueCalculated /= this.fee;
			}
			
			this.$set(this.form, form_item, valueCalculated);
		},
		calculateHourPrice(form_item, hours = 1, net) {
			let value = form_item / hours;
			
			if (!net) {
				value *= this.fee;
			}
			
			return Math.floor(value);
		},
		calculateGrossPrice(value) {
			value = parseInt(value, 10);

			return Math.floor(value * this.fee);
		},
		addNewSpokenLanguage() {
			const languageTemplate = JSON.parse(JSON.stringify(this.languageTemplate));
			this.form.spoken_languages.push(languageTemplate);
		},
		addNewTeachingLanguage() {
			const languageTemplate = JSON.parse(JSON.stringify(this.languageTemplate));
			this.form.teaching_languages.push(languageTemplate);
		},
		submit() {
			//TODO: reset localStorage
			this.form.post('/users/' + this.$page.props.user.id, {
				preserveScroll: true, 
				onSuccess: () => {
					let message = this.trans.get('teacher_application.submit_notification_success');
					this.$toast.success(message);
					localStorage.removeItem('teacher-application');
				},
				onError: error => {
					console.error(error);
					let message = this.trans.get('teacher_application.submit_notification_fail');
					this.$toast.error(message);
				}
			});
		},
		updateProfilePhotoPreview() {
	        const reader = new FileReader();
	
	        reader.onload = (e) => {
		        this.profilePhotoPreview = e.target.result;
	        };

	        reader.readAsDataURL(this.$refs.profile_photo.files[0]);
        },
        updateVerificationPhotoPreview() {
	        const reader = new FileReader();
	
	        reader.onload = (e) => {
		        this.verificationPhotoPreview = e.target.result;
	        };

	        reader.readAsDataURL(this.$refs.verification_photo.files[0]);
        },
		nextTab() {
			this.form.step = this.activeTab;

			if (this.form.teaching_languages.length !== 0) {
				this.form.teaching_languages = this.form.teaching_languages[0].language == null || this.form.teaching_languages[0].level == null ? [] : this.form.teaching_languages;
			}

			if (this.form.spoken_languages.length !== 0) {
				this.form.spoken_languages = this.form.spoken_languages[0].language == null  || this.form.spoken_languages[0].level == null ? [] : this.form.spoken_languages;
			}

			if (this.$refs.profile_photo) {
				console.log();
                this.form.photo = this.$refs.profile_photo.files[0];
            }

            if (this.$refs.verification_photo) {
                this.form.verification_photo = this.$refs.verification_photo.files[0];
            }

			this.form.post('/teacher/' + this.teacher.id, { 
				preserveScroll: true, 
				onSuccess: page => {
                	if (Object.keys(page.props.errors).length === 0) {
	                	if (this.activeTab < this.tabs.length ) {
	                		this.activeTab ++;
						}
	                }
	           	},
				onError: error => {
					let message = this.trans.get('teacher_application.next_tab_notification_fail');
					this.$toast.error(message);
					console.error(error)
				}
			});
		},
		prevTab() {
			if (this.activeTab > 0) {
				this.activeTab --;
			}
		}
	}
}
</script>

