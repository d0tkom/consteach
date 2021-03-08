<template>
	<app-layout>
		<main>
			<section class="top">
				<div class="flex firstSectionFlex">
					<div class="left flex flex-col justify-center ml-16">
						<div class="title">Online, személyesen neked</div>
						<p>Találj hozzád illő tanárt, tanulj anyanyelvi szinten, otthonod kényelméből</p>
						<c-btn
							large
							glow
							navigate-to="/teachers"
						>INGYENES PRÓBAÓRA</c-btn>
						<div class="globe-and-book"></div>
					</div>
					<div class="right">
						<img src="/img/girl_light.svg" alt="Nyelvtanuló nő laptoppal">
					</div>
				</div>
				<div class="bottom-img"></div>
			</section>
			
			<section class="choose-a-language">
				<div class="section-content">
					<div class="base-line"></div>
					<div class="base-title pt-4">
						Válassz nyelvet!
					</div>
					<div class="container py-4">
						
						<div
							v-for="language in availableLanguagesFiltered"
							:key="language"
							class="flex flex-col text-center items-center justify-center lang show-mobile"
						>
							<flag
								class="flagImg rounded-full mb-4 text-8xl shadow-md"
								:iso="language === 'en' ? 'us' : language"
							/>
							<div class="title capitalize font-md font-bold">{{ languageList[language] }}</div>
						</div>
					</div>
					<div class="lang-button-container">
						<c-btn
							large
							glow
							class="mt-4"
							outlined
							:icon="moreLanguages ? 'remove_circle_outline' : 'add_circle_outline'"
							@click="moreLanguages = !moreLanguages"
						>{{ !moreLanguages ? 'Összes nyelv' : 'Kevesebb nyelv'}}</c-btn>
					</div>
				</div>
			</section>
			
			<div class="my-28"></div>
			
			<section class="language-learning">
				<div class="section-content">
					<div class="base-line"></div>
					<div class="base-title pt-4 pb-8">
						Nyelvtanulás egyszerűen
					</div>
					<div class="container flex flex-col">
						<div class="line flex">
							<img class="icon" src="/img/circle1.svg" alt="circle1">
							<div class="title text-xl">Válassz a nyelvek közül</div>
						</div>
						<div class="line flex">
							<img class="icon" src="/img/circle2.svg" alt="circle2">
							<div class="title text-xl">Válassz tanárt magadnak</div>
						</div>
						<div class="line flex">
							<img class="icon" src="/img/circle3.svg" alt="circle3">
							<div class="title text-xl">Foglalj időpontot</div>
						</div>
						<div class="line flex">
							<img class="icon" src="/img/circle4.svg" alt="circle4">
							<div class="title text-xl">Kezdődjön a videóhívás!</div>
						</div>
					</div>
					
					<div class="my-24"></div>
					
					<div class="mb-8 flex mt-12 text-left justify-between">
						<div>
							<h3 class="title font-bold text-2xl">Milyen tanárt keresel?</h3>
							<p class="my-4">
								Válaszd ki a preferenciáid és máris mutatjuk a hozzád illő tanárokat!
							</p>
						</div>
						<div>
							<inertia-link href="/teachers">
								<c-btn
									large
									glow
									navigate-to="/teachers"
								>
									Tanárkeresés
								</c-btn>
							</inertia-link>
						</div>
					</div>
				</div>
			</section>
			
			<div class="wave wave-1"></div>
			
			<section class="next-level">
				<div class="section-content">
					<div class="base-line"></div>
					<div class="base-title pt-4 pb-8">
						Lépj a következő szintre
					</div>
					<div class="container">
						<div class="line pb-10">
							<div class="icon flex justify-center">
								<img src="/img/level_up_1.png" alt="circle1">
							</div>
							<div class="content">
								<div class="title font-bold text-2xl mb-4">Gyors</div>
								<p>Találj hozzád illő tanárt és tanulj anyanyelvi szinten, otthonod kényelméből.</p>
							</div>
						</div>
						<div class="line pb-10 text-align-right">
							<div class="content">
								<div class="title font-bold text-2xl mb-4">Személyre szabott</div>
								<p>Találj hozzád illő tanárt és tanulj anyanyelvi szinten, otthonod kényelméből.</p>
							</div>
							<div class="icon flex justify-center">
								<img src="/img/level_up_2.png" alt="circle2">
							</div>
						</div>
						<div class="line pb-10">
							<div class="icon flex justify-center">
								<img src="/img/level_up_3.png" alt="circle3">
							</div>
							<div class="content">
								<div class="title font-bold text-2xl mb-4">Minőségi</div>
								<p>Találj hozzád illő tanárt és tanulj anyanyelvi szinten, otthonod kényelméből.</p>
							</div>
						</div>
					</div>
					<div class="button-container">
						<c-btn
							large
							glow
							navigate-to="/#registration"
						>Regisztrálok</c-btn>
					</div>
				</div>
			</section>
			
			<div class="wave wave-2"></div>
			
			<section class="teach-with-us">
				<div class="section-content">
					<div class="base-line"></div>
					<div class="base-title pt-4 pb-8">
						Taníts nálunk!
					</div>
					<div class="container">
						<div class="line">
							<div class="icon flex justify-center">
								<img src="/img/circle5.svg" alt="circle5">
							</div>
							<div class="content">
								<div class="title text-2xl font-bold mb-4">Karrier</div>
								<p>Találj hozzád illő tanárt és tanulj anyanyelvi szinten, otthonod kényelméből.</p>
							</div>
						</div>
						<div class="line">
							<div class="icon flex justify-center">
								<img src="/img/circle6.svg" alt="circle6">
							</div>
							<div class="content">
								<div class="title text-2xl font-bold mb-4">Fejlődés</div>
								<p>Találj hozzád illő tanárt és tanulj anyanyelvi szinten, otthonod kényelméből.</p>
							</div>
						</div>
						<div class="line">
							<div class="icon flex justify-center">
								<img src="/img/circle7.svg" alt="circle7">
							</div>
							<div class="content">
								<div class="title text-2xl font-bold mb-4">Tapasztalat</div>
								<p>Találj hozzád illő tanárt és tanulj anyanyelvi szinten, otthonod kényelméből.</p>
							</div>
						</div>
					</div>
					<div class="button-container">
						<c-btn
							large
							glow
							navigate-to="/teacher-landing"
						>Jelentkezem tanárnak</c-btn>
					</div>
				</div>
			</section>
			
			<section class="join-us">
				<div class="svg">
					<svg preserveAspectRatio="none" width="100" height="60" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 875 863"><defs></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><rect class="cls-1" fill="#d3eeff" width="875" height="863"/><path class="cls-2" fill="#a8cbec" style="opacity:0.7" d="M0,863H875V824.27c-211-170.66-875,32-875,32Z"/><path fill="#e8f3fa" style="opacity:0.7" class="cls-3" d="M0,189.7v449S358.67,943,875,824.7V27.7S334.73-92.23,0,189.7Z"/></g></g></svg>
				</div>
				<div class="section-content">
					<div class="base-line"></div>
					<div class="base-title pt-4 pb-8">
						Csatlakozz hozzánk!
					</div>
					<div class="container">
						<div class="videoWrapper">
							<iframe loading="lazy" width="100%" src="https://www.youtube.com/embed/9bZkp7q19f0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>
					<div class="flex justify-center my-4">
						<c-btn
							large
							glow
							navigate-to="/#registration"
						>Regisztrálok</c-btn>
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
	},
	computed: {
		availableLanguagesFiltered() {
			if (this.moreLanguages) {
				return this.$page.props.availableLanguages;
			}
			
			return this.$page.props.availableLanguages.slice(0, 3);
		}
	}
}
</script>