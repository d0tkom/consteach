<template>
	<app-layout>
		<main>
			<section class="top">
				<div class="flex">
					<div class="left flex flex-col justify-center ml-16">
						<div class="title">Taníts nálunk!</div>
						<p>Ha kimagaslóan beszélsz egy nyelvet és szeretnél nyelvet oktatni nálunk a helyed!</p>
						<c-btn
							large
							glow
							@click="clickedRegistration"
						>
							Jelentkezés
						</c-btn>
						<div class="globe-and-book"></div>
					</div>
					<div class="right">
						<img src="/img/girl_light.svg" alt="Nyelvtanuló nő laptoppal">
					</div>
				</div>
				<div class="bottom-img"></div>
			</section>
			
			<div class="wave wave-1"></div>
			
			<section class="next-level">
				<div class="section-content">
					<div class="base-line"></div>
					<div class="text-center mb-8 text-2xl font-bold">
						MIÉRT VÁLASSZ MINKET
					</div>
					<div class="container pt-6">
						<div class="line">
							<div class="icon flex justify-center">
								<img src="/img/circle5_light.svg" alt="circle1">
							</div>
							<div class="content">
								<div class="title text-2xl font-bold mb-4">Rugalmas </div>
								<p>Taníts nyelvet akkor és ott, ahol szeretnél, online!</p>
							</div>
						</div>
						<div class="line text-align-right">
							<div class="content">
								<div class="title text-2xl font-bold mb-4">Tapasztalat</div>
								<p>Szerezz tapasztalatot a tanításban, gyakorld magad oktatóként!</p>
							</div>
							<div class="icon flex justify-center">
								<img src="/img/circle6_light.svg" alt="circle2">
							</div>
						</div>
						<div class="line">
							<div class="icon flex justify-center">
								<img src="/img/circle7_light.svg" alt="circle3">
							</div>
							<div class="content">
								<div class="title text-2xl font-bold mb-4">Kedvező feltételek</div>
								<p>Ingyenes regisztráció, saját óradíj és időbeosztás beállítás!</p>
							</div>
						</div>
					</div>
				</div>
			</section>
			
			<div class="wave wave-2"></div>
			
			
			<section class="join-us">
				<div class="svg">
					<svg preserveAspectRatio="none" width="100" height="60" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 875 863"><defs></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><rect class="cls-1" fill="#d3eeff" width="875" height="863"/><path class="cls-2" fill="#a8cbec" style="opacity:0.7" d="M0,863H875V824.27c-211-170.66-875,32-875,32Z"/><path fill="#e8f3fa" style="opacity:0.7" class="cls-3" d="M0,189.7v449S358.67,943,875,824.7V27.7S334.73-92.23,0,189.7Z"/></g></g></svg>
				</div>
				<div class="section-content">
					<div class="base-line"></div>
					<div class="text-center mb-8 text-2xl font-bold">
						Milyen nálunk tanítani?
					</div>
					<div class="container">
						<div class="videoWrapper">
							<iframe loading="lazy" src="https://www.youtube.com/embed/9bZkp7q19f0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>
					<div class="flex justify-center">
						<c-btn
							large
							glow
							navigate-to="/#registration"
							@click="$root.openRegistrationPopup('teacher')"
						>
							Regisztrálok
						</c-btn>
					</div>
				</div>
			</section>
		</main>
	</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
	components: {
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
	methods: {
		clickedRegistration() {
			this.$root.popup.registrationType = 'teacher';
			this.$root.popup.registration = true
		}
	}
}
</script>