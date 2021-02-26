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
								v-model="form.firstName"
								label="Keresztnév"
							></cInput>
						</div>
						
						<div class="mb-4">
							<cInput
								label="Családnév"
								v-model="form.lastName"
							></cInput>
						</div>
						
						<div class="mb-4">
							<cInput
								label="Email cím"
								v-model="form.email"
							></cInput>
						</div>
						
						<div class="mb-4">
							<c-select
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
							/>
						</div>
						
						<!-- Tanított nyelvek -->
						<div class="mb-4">
							<div
								class="grid md:grid-cols-2 grid-cols-1 gap-4 mb-4"
								v-for="(language, languageIndex) in form.languagesToTeach"
								:key="languageIndex"
							>
								<div>
									<c-select
										:data="[{label: 'Angol'}, {label: 'Magyar'}]"
										label="Tanított nyelv"
										labelKey="label"
										valueKey="label"
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
								@click="addNewLanguage"
							>
								Nyelv hozzáadása
							</c-btn>
						</div>
						
						<hr class="mb-4" />
						
						<!-- Beszélt nyelvek -->
						<div>
							<div
								class="grid md:grid-cols-2 grid-cols-1 gap-4 mb-4"
								v-for="(language, languageIndex) in form.languages"
								:key="'ltn-'+languageIndex"
							>
								<div>
									<c-select
										:data="[{label: 'Angol'}, {label: 'Magyar'}]"
										label="Beszélt nyelv"
										labelKey="label"
										valueKey="label"
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
								@click="addNewLanguage"
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
				2
			</div>
			<div class="card" v-if="activeTab === 2">
				3
			</div>
			<div class="card" v-if="activeTab === 3">
				<h2 class="title text-lg color-primary-dark font-bold">Bemutatkozás</h2>
				<div class="color-blue-dark">Mutatkozz be leendő diákjaidnak!</div>
				<div class="content mt-4">
					<form>
						<c-text-area
							class="mb-4"
							label="Bemutatkozás magyarul"
							v-model="form.description_hu"
						/>
						<c-text-area
							label="Bemutatkozás angolul"
							v-model="form.description_hu"
						/>
					</form>
				</div>
			</div>
			<div class="card" v-if="activeTab === 4">
				<h2 class="title text-lg color-primary-dark mb-4 font-bold">Elérhetőség</h2>
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
					:loading="saving"
					class="mr-2"
					v-show="activeTab > 0 && !saving"
					@click="prevTab"
					icon="keyboard_arrow_left"
				>Vissza</c-btn>
				<c-btn
					v-if="activeTab !== tabs.length"
					:loading="saving"
					class="ml-2"
					@click="nextTab"
					icon-right="keyboard_arrow_right"
				>Tovább</c-btn>
				<c-btn
					v-if="activeTab === tabs.length"
					:loading="saving"
					class="ml-2"
					@click="saveApplication"
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

export default {
	components: {
		AppLayout,
		
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
			form: {
				firstName: 'Janos',
				lastName: '',
				email: '',
				country: null,
				youtube: null,
				adult: false,
				languagesToTeach: [
					{
						language: 'Magyar',
						level: 'C2'
					}, {
						language: 'Angol',
						level: 'Anyanyelvi szint'
					}
				],
				languages: [
					{
						language: 'Magyar',
						level: 'C2'
					}, {
						language: 'Angol',
						level: 'Anyanyelvi szint'
					}
				]
			}
		};
	},
	methods: {
		addNewLanguage() {
			const languageTemplate = JSON.parse(JSON.stringify(this.languageTemplate));
			this.form.languages.push(languageTemplate);
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
		saveApplication() {
			this.saving = true;
			
			setTimeout(() => {
				console.warn('TODO: save application form');
				this.saving = false;
			}, 2400);
		}
	}
}
</script>