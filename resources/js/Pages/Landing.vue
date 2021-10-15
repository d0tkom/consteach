<template>
	<app-layout>
		<main>
			<div class="hero">
				<section class="top">
					<div class="flex firstSectionFlex">
						<div class="left flex flex-col justify-center">
							<div class="title font-bold">
								{{ trans.get('landing.hero_title') }}
							</div>
							<p>
								{{ trans.get('landing.hero_subtitle') }}
							</p>
							<c-btn
								class="mt-4"
								large
								glow
								navigate-to="/teachers"
							>
								{{ trans.get('landing.hero_cta') }}
							</c-btn>
						</div>
						<div class="right">
							<img class="landingGirl" src="/img/girl_light.svg" alt="Nyelvtanuló nő laptoppal">
							<img class="landingTree" src="/img/landing_tree.svg" alt="Nyelvtanuló növény">
						</div>
					</div>
				</section>

				<section class="choose-a-language">
					<div class="section-content">
						<div class="base-line"></div>
						<div class="base-title pt-4">
							{{ trans.get('landing.hero_choose_language') }}
						</div>
						<div class="container py-4">
							<inertia-link
								:href="'/teachers?language='+language"
								v-for="language in availableLanguagesFiltered"
								v-if="language"
								:key="language"
								class="flex flex-col text-center items-center justify-center lang show-mobile"
							>
								<flag
									class="flagImg rounded-full mb-4 text-8xl shadow-md"
									:iso="$root.getCountryCode(language)"
								/>
								<div class="title capitalize text-xl font-md font-bold">
									{{ languageList[language] }}
								</div>
							</inertia-link>
						</div>
						<div class="lang-button-container" v-if="availableLanguagesFiltered.length > 6">
							<c-btn
								large
								glow
								class="mt-4"
								text
								:icon="moreLanguages ? 'remove_circle_outline' : 'add_circle_outline'"
								@click="moreLanguages = !moreLanguages"
							>
								{{ trans.get(!moreLanguages ? 'landing.hero_more_language_btn' : 'landing.hero_less_language_btn') }}
							</c-btn>
						</div>
					</div>
				</section>
			</div>

			<section class="language-learning">
				<div class="section-content">
					<div class="base-line"></div>
					<div class="base-title">
						{{ trans.get('landing.language_learning_title') }}
					</div>
					<div class="container grid grid-cols-4">
						<div class="line flex">
							<img class="icon" src="/img/circle1.svg" alt="circle1">
							<div class="title text-xl">
								{{ trans.get('landing.language_learning_card_1') }}
							</div>
						</div>
						<div class="line flex">
							<img class="icon" src="/img/circle2.svg" alt="circle2">
							<div class="title text-xl">
								{{ trans.get('landing.language_learning_card_2') }}
							</div>
						</div>
						<div class="line flex">
							<img class="icon" src="/img/circle3.svg" alt="circle3">
							<div class="title text-xl">
								{{ trans.get('landing.language_learning_card_3') }}
							</div>
						</div>
						<div class="line flex">
							<img class="icon" src="/img/circle4.svg" alt="circle4">
							<div class="title text-xl">
								{{ trans.get('landing.language_learning_card_4') }}
							</div>
						</div>
					</div>

					<div class="mb-8 mt-24 text-center">
						<h3 class="title font-bold text-2xl">
							{{ trans.get('landing.language_learning_find_teacher_title') }}
						</h3>
						<p class="mt-4 mb-8">
							{{ trans.get('landing.language_learning_find_teacher_subtitle') }}
						</p>

						<div>
							<inertia-link class="inline-flex" href="/teachers">
								<c-btn
									large
									glow
									icon="person_search"
								>
									{{ trans.get('landing.language_learning_find_teacher_btn') }}
								</c-btn>
							</inertia-link>
						</div>
					</div>
				</div>
			</section>

			<section class="next-level">
				<div class="section-content">
					<div class="base-line"></div>
					<div class="base-title pt-4 pb-8">
						{{ trans.get('landing.next_level_title') }}
					</div>
					<div class="container">
						<div class="line pb-10">
							<div class="icon flex justify-center">
								<img
									class="nextLevelIcon-1"
									width="87"
									height="133"
									src="/img/level_up_1.png"
									alt="circle1"
								>
							</div>
							<div class="content">
								<div class="title font-bold text-2xl mb-4">
									{{ trans.get('landing.next_level_card_1_title') }}
								</div>
								<p>
									{{ trans.get('landing.next_level_card_1_subtitle') }}
								</p>
							</div>
						</div>
						<div class="line pb-10 text-align-right">
							<div class="content">
								<div class="title font-bold text-2xl mb-4">
									{{ trans.get('landing.next_level_card_2_title') }}
								</div>
								<p>
									{{ trans.get('landing.next_level_card_2_subtitle') }}
								</p>
							</div>
							<div class="icon flex justify-center">
								<img
									width="155"
									height="155"
									src="/img/level_up_2.png"
									alt="circle2"
								>
							</div>
						</div>
						<div class="line pb-10">
							<div class="icon flex justify-center">
								<img
									width="155"
									height="155"
									src="/img/level_up_3.png"
									alt="circle3"
								>
							</div>
							<div class="content">
								<div class="title font-bold text-2xl mb-4">
									{{ trans.get('landing.next_level_card_3_title') }}
								</div>
								<p>
									{{ trans.get('landing.next_level_card_3_subtitle') }}
								</p>
							</div>
						</div>
					</div>
					<div class="button-container">
						<c-btn
							large
							glow
							icon="person_add"
							@click="$root.openRegistrationPopup"
						>
							{{ trans.get('landing.next_level_registration_btn') }}
						</c-btn>
					</div>
				</div>
			</section>

			<section id="teach-with-us" class="teach-with-us">
				<div class="section-content">
					<div class="base-line"></div>
					<div class="base-title pt-4 pb-8">
						{{ trans.get('landing.teach_with_us_title') }}
					</div>
					<div class="container">
						<div class="line">
							<div class="icon flex justify-center">
								<img src="/img/circle5.svg" alt="circle5">
							</div>
							<div class="content w-full md:w-1/2">
								<div class="title text-2xl font-bold mb-4">
									{{ trans.get('landing.teach_with_us_card_1_title') }}
								</div>
								<p>
									{{ trans.get('landing.teach_with_us_card_1_subtitle') }}
								</p>
							</div>
						</div>
						<div class="line">
							<div class="icon flex justify-center">
								<img src="/img/circle6.svg" alt="circle6">
							</div>
							<div class="content w-1/2">
								<div class="title text-2xl font-bold mb-4">
									{{ trans.get('landing.teach_with_us_card_2_title') }}
								</div>
								<p>
									{{ trans.get('landing.teach_with_us_card_2_subtitle') }}
								</p>
							</div>
						</div>
						<div class="line">
							<div class="icon flex justify-center">
								<img src="/img/circle7.svg" alt="circle7">
							</div>
							<div class="content w-1/2">
								<div class="title text-2xl font-bold mb-4">
									{{ trans.get('landing.teach_with_us_card_3_title') }}
								</div>
								<p>
									{{ trans.get('landing.teach_with_us_card_3_subtitle') }}
								</p>
							</div>
						</div>
					</div>
					<div class="button-container">
						<c-btn
							large
							glow
							@click="teachWithUsClicked"
						>
							{{ trans.get('landing.teach_with_us_cta') }}
						</c-btn>
					</div>
				</div>
			</section>

			<section class="join-us">
				<div class="section-content">
					<div class="base-line"></div>
					<div class="base-title pt-4 pb-8">
						{{ trans.get('landing.join_us_title') }}
					</div>
					<div class="container">
						<div class="videoWrapper">
							<iframe
								loading="lazy"
								width="100%"
								:src="trans.get('landing.join_us_youtube_embed_url')"
								frameborder="0"
								allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
								allowfullscreen
							></iframe>
						</div>
					</div>
					<div class="flex justify-center mt-8">
						<c-btn
							large
							glow
							icon="badge"
							@click="$root.openRegistrationPopup('student')"
						>
							{{ trans.get('landing.join_us_cta') }}
						</c-btn>
					</div>
				</div>
			</section>
		</main>
	</app-layout>
</template>

<script>

import SiteHeader from "@/Layouts/Partials/SiteHeader";
import LoginPopup from "@/Pages/Landing/LoginPopup";
import RegisterPopup from "@/Pages/Landing/RegisterPopup";
import LostPasswordPopup from "@/Pages/Landing/LostPasswordPopup";
import AppLayout from '../Layouts/AppLayout.vue';

export default {
	components: {
		LostPasswordPopup,
		RegisterPopup,
		LoginPopup,
		SiteHeader,
		AppLayout
	},
	props: {
		availableLanguages: {
			type: Array,
			default() {
				return [];
			}
		}
	},
	data() {
		return {
			moreLanguages: false,
			languageList: [],
			locale: window.default_locale,
		}
	},
	created() {
		this.languageList = require('@cospired/i18n-iso-languages');
		this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/en.json'));
		this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/hu.json'));
		this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/de.json'));

		this.languageList = this.languageList.getNames(this.locale, {select: 'official'});

		this.availableLanguages[3] = 'it';
	},
	mounted() {
		let title = this.trans.get('landing.document_title');
		this.$root.documentTitle(title, false);

		this.$root.initHashScroll();
	},
	computed: {
		availableLanguagesFiltered() {
			if (this.moreLanguages) {
				return this.$page.props.availableLanguages;
			}

			return this.$page.props.availableLanguages.slice(0, 6);
		}
	},
	methods: {
		teachWithUsClicked() {
			this.$root.openRegistrationPopup('teacher')
		}
	}
}
</script>
