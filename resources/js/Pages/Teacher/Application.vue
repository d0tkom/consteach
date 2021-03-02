<template>
	<app-layout>
		<div class="card md flat teacherApplicationContainer">
			<div class="tabs p-4 mb-4 bg-white rounded-xl shadow-md border blue-border items-center relative">
				<div class="sm:flex text-center blue-text-color">
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
						<div>{{ tab.label }}</div>
					</div>
				</div>
			</div>
			<div class="card" v-if="activeTab === 0">
				<h2 class="title text-lg color-primary-dark mb-4 font-bold">Felhasználói adatok</h2>
				<div class="content">
					<form>
						<div class="mb-4">
							<cInput
								v-model="form.first_name"
								label="Keresztnév"
							></cInput>
						</div>
						
						<div class="mb-4">
							<cInput
								label="Családnév"
								v-model="form.last_name"
							></cInput>
						</div>
						
						<div class="mb-4">
							<cInput
								readonly
								label="Email cím"
								v-model="form.email"
							></cInput>
						</div>
						
						<div class="mb-4">
							<c-select
								capitalize
								:data="countries"
								label="Származási hely"
								labelKey="name"
								valueKey="code"
								v-model="form.country"
							/>
						</div>
						
						<div class="mb-4">
							<c-select
								class="mb-4"
								label="Időzóna"
								:data="timezones"
								label-key="name"
								value-key="code"
								v-model="form.timezone"
							/>
						</div>
						
						<!-- Tanított nyelvek -->
						<div class="mb-4">
							<div class="title color-gray mb-2">Tanított nyelvek</div>
							<div
								class="grid md:grid-cols-2 grid-cols-1 gap-4 mb-4"
								v-for="(language, languageIndex) in form.teaching_languages"
								:key="languageIndex"
							>
								<div>
									<c-select
										capitalize
										:data="languageList"
										label="Nyelv"
										labelKey="name"
										valueKey="code"
										v-model="language.language"
									/>
								</div>
								
								<div>
									<c-select
										:data="levels"
										label="Szint"
										labelKey="label"
										valueKey="code"
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
							<div class="title color-gray mb-2">Beszélt nyelvek</div>
							<div
								class="grid md:grid-cols-2 grid-cols-1 gap-4 mb-4"
								v-for="(language, languageIndex) in form.spoken_languages"
								:key="'ltn-'+languageIndex"
							>
								<div>
									<c-select
										capitalize
										:data="languageList"
										label="Nyelv"
										labelKey="name"
										valueKey="code"
										v-model="language.language"
									/>
								</div>
								
								<div>
									<c-select
										:data="levels"
										label="Szint"
										labelKey="label"
										valueKey="code"
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
						<c-checkbox
							class="my-2"
							v-model="form.adult"
						>Elmúltam 18 éves</c-checkbox>
					</form>
				</div>
			</div>
			<div class="card" v-if="activeTab === 1">
				<div class="sm:flex">
					<div class="sm:w-7/12 w-full mr-8">
						<h2 class="title text-lg color-primary-dark mb-4 font-bold">Profilkép</h2>
						<p class="mb-3 text-md">
							Készíts egy jól megvilágított, jókedvű fotót. A jó profilkép fél siker, több hallgatót érhetsz el vele.
						</p>
						<div class="flex items-center mb-4">
							<c-input
								type="file"
								only-slot
								class=""
							>
								<c-btn
									icon="add_photo_alternate"
								>Fotó feltöltése</c-btn>
							</c-input>
							<span class="text-xs text-gray-500 ml-4">JPG vagy PNG<br/>Max.: 5MB</span>
						</div>
						<div class="text-center">
							<img class="block mb-2 w-full" src="/img/profile_img_test.jpg" alt="Man">
							<span class="text-gray-500 text-xs">Példa</span>
						</div>
					</div>
					<div class="sm:w-5/12 w-full">
						<span class="block text-md font-semibold mb-6">Tippek</span>
						<div class="flex mb-5">
							<img class="block mx-auto h-20 sm:h-16 rounded-full m-auto" src="/img/profile_photo_tip_1.png" alt="Woman's Face">
							<img class="block mx-auto h-20 sm:h-16 rounded-full m-auto" src="/img/profile_photo_tip_2.png" alt="Woman's Face">
							<img class="block mx-auto h-20 sm:h-16 rounded-full m-auto" src="/img/profile_photo_tip_3.png" alt="Woman's Face">
						</div>

						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">Mosolyogj és nézz a kamerába</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">Legyen az arcod fókuszban</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">Használj semleges hátteret és világítást</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">Kerüld a logókat és a brand jelzéseket</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">Szerepelj csak te a fotón</span>
						</div>
					</div>
				</div>
			</div>
			<div class="card" v-if="activeTab === 2">
				<div class="sm:flex">
					<div class="sm:w-7/12 w-full mr-8">
						<h2 class="title text-lg color-primary-dark mb-4 font-bold">Bemutatkozó videó</h2>
						<p class="mb-3 text-md">
							Illeszd be a bemutatkozó videód linkjét. Videó feltöltése nem kötelező, de egy magabiztos videó megosztása sokban segíthet új diákokat szerezni. Később még könnyedén tölthetsz fel bemutatkozó videót!
						</p>
						<div class="flex flex-col mb-4">
							<c-input
								class="mb-2"
								type="text"
								v-model="form.video_url"
								:error="!!$page.props.errors.video_url"
								label="Youtube link"
							/>
							<iframe v-if="form.video_url" width="100%" height="200" :src="form.video_url.replace('watch?v=', 'embed/')" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>
					<div class="sm:w-5/12 w-full">
						<span class="block text-md font-semibold mb-6">Tippek</span>
						<div class="flex mb-5">
							<img class="block mx-auto h-20 sm:h-16 rounded-full m-auto" src="/img/profile_photo_tip_1.png" alt="Woman's Face">
							<img class="block mx-auto h-20 sm:h-16 rounded-full m-auto" src="/img/profile_photo_tip_2.png" alt="Woman's Face">
							<img class="block mx-auto h-20 sm:h-16 rounded-full m-auto" src="/img/profile_photo_tip_3.png" alt="Woman's Face">
						</div>

						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">Maximum 2 perces videót ossz meg</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">Horizontális módban vedd fel</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">Az arcod legyen fókuszban</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">Semleges hátteret és fényeket használj</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">Kerüld a logókat és brand jelzéseket</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">Csak te szerepelj a videón</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">Köszöntsd leendő diákjaidat</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">Bátorítsd a diákokat prbóaóra foglalására</span>
						</div>
						<div class="flex items-center my-2">
							<i class="material-icons mr-2 text-green-500">check_circle_outline</i>
							<span class="text-md justify-center">Beszélj korábbi munkatapasztalataidról</span>
						</div>
					</div>
				</div>
			</div>
			<div class="card" v-if="activeTab === 3">
				<h2 class="title text-lg color-primary-dark font-bold">Bemutatkozás</h2>
				<div class="color-blue-dark">Mutatkozz be leendő diákjaidnak!</div>
				<div class="content mt-4">
					<form>
						<c-text-area
							hint="Minimum 250 karakter"
                            :max="2000"
							class="mb-4"
							label="Bemutatkozás magyarul"
							v-model="form.about_me_hu"
						/>
						<c-text-area
							hint="Minimum 250 karakter"
                            :max="2000"
							label="Bemutatkozás angolul"
							v-model="form.about_me_en"
						/>
					</form>
				</div>
			</div>
			<div class="card" v-if="activeTab === 4">
				<h2 class="title text-lg color-primary-dark mb-4 font-bold">Elérhetőség</h2>
				<FullCalendar :options="calendarOptions" />
			</div>
			<div class="card" v-if="activeTab === 5">
				<h2 class="title text-lg color-primary-dark font-bold">Verifikáció</h2>
				<p>Már csak egy lépcső szükséges ahhoz hogy el tudj kezdeni tanítani nálunk!
					Kérjük tölts fel egy fotót magadról és tartsd az arcod mellé útleveledet, vagy személyi igazolványodat. </p>
				<c-input
					type="file"
					only-slot
					class="mt-4"
				>
					<c-btn
						icon="insert_photo"
					>Kép feltöltése</c-btn>
				</c-input>
			
			</div>
			<div class="actions flex justify-center">
				<c-btn
					:loading="form.processing"
					class="mr-2"
					v-show="activeTab > 0 && !form.processing"
					@click="prevTab"
					icon="keyboard_arrow_left"
				>Vissza</c-btn>
				<c-btn
					v-if="activeTab !== tabs.length"
					:loading="form.processing"
					class="ml-2"
					@click="nextTab"
					icon-right="keyboard_arrow_right"
				>Tovább</c-btn>
				<c-btn
					v-if="activeTab === tabs.length"
					:loading="form.processing"
					class="ml-2"
					@click="submitaddNewLanguage"
					icon="done"
				>Jelentkezés véglegesítése</c-btn>
			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import countries from '@/Partials/countries'
import languages from '@/Partials/languages'
import currencies from '@/Partials/currencies'
import timezones from '@/Partials/timezones'
import levels from '@/Partials/levels'

import FullCalendar from '@fullcalendar/vue';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

export default {
	components: {
		AppLayout,
		FullCalendar
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
	data() {
		return {
			countries,
			languages,
			languageList: null,
			currencies,
			timezones,
			levels,
			locale: window.default_locale,
			
			languageTemplate: {
				language: null,
				level: null
			},
			
			activeTab: 0,
			tabs: [
				{
					label: 'Felhasználói adatok',
					id: 0,
				}, {
					label: 'Profilkép',
					id: 1,
				}, {
					label: 'Videó',
					id: 2,
				}, {
					label: 'Bemutatkozás',
					id: 3,
				}, {
					label: 'Elérhetőség',
					id: 4,
				},
			],
			form: this.$inertia.form({
				first_name: this.$page.props.user.first_name,
				last_name: this.$page.props.user.last_name,
				email: this.$page.props.user.email,
				country: null,
				timezone: null,
				about_me_hu: null,
				about_me_en: null,
				video_url: null,
				teaching_languages: [],
				spoken_languages: [],
				adult: false,
			}),
			calendarOptions: {
				plugins: [ timeGridPlugin, interactionPlugin ],
				initialView: 'timeGridWeek',
				locale: window.default_locale,
				buttonText: {
					today:    'mai nap',
					month:    'hónap',
					week:     'hét',
					day:      'nap',
					list:     'lista'
				},
				allDayText: 'egész nap',
				firstDay: 1,
				slotDuration: '01:00:00',
				dayHeaderFormat: { 
					weekday: 'long' ,
					day: 'numeric',
					omitCommas: true
				},
				allDaySlot: false,
				slotLabelFormat: {
					hour: '2-digit',
					minute: '2-digit',
					meridiem: 'long'
				},
				headerToolbar: {
					left: 'prev',
					center: 'title',
					right: 'next'
				},
				events: [],
				selectable: true,
				selectOverlap: false,
				select: function (selectionInfo) {
					console.log(selectionInfo);
					axios.put('/availability', {params: {
						start: selectionInfo.startStr,
						end: selectionInfo.endStr
					}})
					.then(function (response) {
						console.log(response);
					})
					.catch(function (error) {
						console.log(error);
					});
				},
			}
		};
	},
	watch: {
		form: {
			handler(form) {
				localStorage.setItem('teacher-application', JSON.stringify(form));
			},
			deep: true
		}
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
			this.form.post('/api/teacher-application', {
				preserveScroll: true,
				onSuccess: () => {
					this.$toast.success('Sikeres mentés');
				}
			});
		},
		nextTab() {
			if (this.activeTab < this.tabs.length) {
				this.activeTab ++;
			}
		},
		prevTab() {
			if (this.activeTab > 0) {
				this.activeTab --;
			}
		},
	}
}
</script>