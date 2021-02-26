<template>
	<div>
		<site-header />
		<main>
			<section class="top">
				<div class="flex">
					<div class="left flex flex-col justify-center ml-16">
						<div class="title">Online, személyesen neked</div>
						<p>Találj hozzád illő tanárt, tanulj anyanyelvi szinten, otthonod kényelméből</p>
						<c-btn
							navigate-to="/teachers"
						>INGYENES Próbaóra</c-btn>
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
					<div class="base-title">
						Válassz nyelvet!
					</div>
					<div class="container">
						<div
							v-for="language in $page.props.availableLanguages"
							class="lang show-mobile"
						>
							<div class="flag">
								<img
									:src="'/img/flags/flag_'+language+'.svg'"
									:alt="language+' Flag'"
								>
							</div>
							<div class="title capitalize">{{ languageList[language] }}</div>
						</div>
					</div>
					<div class="lang-button-container">
						<div class="open">Még több nyelv <span class="down-arrow"></span></div>
						<div class="close">Kevesebb nyelv <span class="up-arrow"></span></div>
					</div>
				</div>
			</section>
			
			<section class="language-learning">
				<div class="section-content">
					<div class="base-line"></div>
					<div class="base-title">
						Nyelvtanulás egyszerűen
					</div>
					<div class="container">
						<div class="line">
							<div class="icon">
								<img src="/img/circle1.svg" alt="circle1">
							</div>
							<div class="title">Válassz a nyelvek közül</div>
						</div>
						<div class="line">
							<div class="icon">
								<img src="/img/circle2.svg" alt="circle2">
							</div>
							<div class="title">Válassz tanárt magadnak</div>
						</div>
						<div class="line">
							<div class="icon">
								<img src="/img/circle3.svg" alt="circle3">
							</div>
							<div class="title">Foglalj időpontot</div>
						</div>
						<div class="line">
							<div class="icon">
								<img src="/img/circle4.svg" alt="circle4">
							</div>
							<div class="title">Csatlakozz a videóhíváshoz és kezdődhet a tanulás!</div>
						</div>
					</div>
					<div class="button-container">
						<p>
							Milyen tanárt keresel? Válaszd ki a preferenciáid és máris mutatjuk a hozzád illő tanárokat!
						</p>
						<c-btn
							navigate-to="/teachers"
						>Tanárkeresés</c-btn>
					</div>
				</div>
			</section>
			
			<div class="wave wave-1"></div>
			
			<section class="next-level">
				<div class="section-content">
					<div class="base-line"></div>
					<div class="base-title">
						Lépj a következő szintre
					</div>
					<div class="container">
						<div class="line">
							<div class="icon flex justify-center">
								<img src="/img/level_up_1.png" alt="circle1">
							</div>
							<div class="content">
								<div class="title">Gyors</div>
								<p>Találj hozzád illő tanárt és tanulj anyanyelvi szinten, otthonod kényelméből.</p>
							</div>
						</div>
						<div class="line text-align-right">
							<div class="content">
								<div class="title">Személyre szabott</div>
								<p>Találj hozzád illő tanárt és tanulj anyanyelvi szinten, otthonod kényelméből.</p>
							</div>
							<div class="icon flex justify-center">
								<img src="/img/level_up_2.png" alt="circle2">
							</div>
						</div>
						<div class="line">
							<div class="icon flex justify-center">
								<img src="/img/level_up_3.png" alt="circle3">
							</div>
							<div class="content">
								<div class="title">Minőségi</div>
								<p>Találj hozzád illő tanárt és tanulj anyanyelvi szinten, otthonod kényelméből.</p>
							</div>
						</div>
					</div>
					<div class="button-container">
						<c-btn
							navigate-to="/#registration"
						>Regisztrálok</c-btn>
					</div>
				</div>
			</section>
			
			<div class="wave wave-2"></div>
			
			<section class="teach-with-us">
				<div class="section-content">
					<div class="base-line"></div>
					<div class="base-title">
						Taníts nálunk
					</div>
					<div class="container">
						<div class="line">
							<div class="icon">
								<img src="/img/circle5.png" alt="circle5">
							</div>
							<div class="content">
								<div class="title">Karrier</div>
								<p>Találj hozzád illő tanárt és tanulj anyanyelvi szinten, otthonod kényelméből.</p>
							</div>
						</div>
						<div class="line">
							<div class="icon">
								<img src="/img/circle6.png" alt="circle6">
							</div>
							<div class="content">
								<div class="title">Fejlődés</div>
								<p>Találj hozzád illő tanárt és tanulj anyanyelvi szinten, otthonod kényelméből.</p>
							</div>
						</div>
						<div class="line">
							<div class="icon">
								<img src="/img/circle7.png" alt="circle7">
							</div>
							<div class="content">
								<div class="title">Tapasztalat</div>
								<p>Találj hozzád illő tanárt és tanulj anyanyelvi szinten, otthonod kényelméből.</p>
							</div>
						</div>
					</div>
					<div class="button-container">
						<c-btn
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
					<div class="base-title">
						Csatlakozz hozzánk
					</div>
					<div class="container">
						<div class="videoWrapper">
							<iframe loading="lazy" src="https://www.youtube.com/embed/9bZkp7q19f0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>
					<div class="flex justify-center my-4">
						<c-btn
							navigate-to="/#registration"
						>Regisztrálok</c-btn>
					</div>
				</div>
			</section>
		</main>
		<site-footer />
	</div>
</template>

<script>

import SiteHeader from "@/Layouts/Partials/SiteHeader";
import LoginPopup from "@/Pages/Landing/LoginPopup";
import RegisterPopup from "@/Pages/Landing/RegisterPopup";
import LostPasswordPopup from "@/Pages/Landing/LostPasswordPopup";
import SiteFooter from "@/Layouts/Partials/SiteFooter";

export default {
	components: {
		LostPasswordPopup,
		RegisterPopup,
		LoginPopup,
		SiteHeader,
		SiteFooter,
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
	}
}
</script>