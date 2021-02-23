<template>
	<div>
		<landing-header />
		<main>
			<section class="top">
				<div class="flex">
					<div class="left flex flex-col justify-center ml-16">
						<div class="title">Online, személyesen neked</div>
						<p>Találj hozzád illő tanárt, tanulj anyanyelvi szinten, otthonod kényelméből</p>
						<button class="button">INGYENES Próbaóra</button>
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
								<img src="/img/flag_GB.png" alt="flag_GB">
							</div>
							<div class="title">{{ language }}</div>
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
								<img src="/img/circle1.png" alt="circle1">
							</div>
							<div class="title">Válassz a nyelvek közül</div>
						</div>
						<div class="line">
							<div class="icon">
								<img src="/img/circle2.png" alt="circle2">
							</div>
							<div class="title">Válassz tanárt magadnak</div>
						</div>
						<div class="line">
							<div class="icon">
								<img src="/img/circle3.png" alt="circle3">
							</div>
							<div class="title">Foglalj időpontot</div>
						</div>
						<div class="line">
							<div class="icon">
								<img src="/img/circle4.png" alt="circle4">
							</div>
							<div class="title">Csatlakozz a videóhíváshoz és kezdődhet a tanulás!</div>
						</div>
					</div>
					<div class="button-container">
						<p>
							Milyen tanárt keresel? Válaszd ki a preferenciáid és máris mutatjuk a hozzád illő tanárokat!
						</p>
						<a href="/find-teacher" class="button">Tanárkeresés</a>
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
							<div class="icon"><img src="/img/level_up_1.png" alt="circle1"></div>
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
							<div class="icon"><img src="/img/level_up_2.png" alt="circle2"></div>
						</div>
						<div class="line">
							<div class="icon"><img src="/img/level_up_3.png" alt="circle3"></div>
							<div class="content">
								<div class="title">Minőségi</div>
								<p>Találj hozzád illő tanárt és tanulj anyanyelvi szinten, otthonod kényelméből.</p>
							</div>
						</div>
					</div>
					<div class="button-container">
						<a href="/register" class="button">Regisztrálok</a>
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
						<button class="button">Jelentkezek tanárnak</button>
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
					<div class="button-container">
						<a href="/register" class="button">Regisztrálok</a>
					</div>
				</div>
			</section>
		</main>
		
		<footer>
			<div class="container">
				<div class="column">
					<div class="title">Weboldal</div>
					<a href="#">Oldal nyelve</a>
					<a href="#">Gyakori kérdések</a>
					<a href="/register">Regisztráció</a>
					<a href="#">Tanítani szeretnék</a>
				</div>
				<div class="column">
					<div class="title">Consteach</div>
					<a href="#">Rólunk</a>
					<a href="#">Hírek</a>
					<a href="#">Blog</a>
					<a href="#">Közösség</a>
				</div>
				<div class="column">
					<div class="title">Social</div>
					<a href="#"><i class="fab fa-facebook"></i></a>
					<a href="#"><i class="fab fa-instagram"></i></a>
					<a href="#"><i class="fab fa-linkedin-in"></i></a>
					<a href="#"><i class="fab fa-twitter"></i></a>
				</div>
				<div class="column">
					<div class="title">Policies</div>
					<a href="#">Privacy</a>
					<a href="#">Terms of Use</a>
					<a href="#">Site Map</a>
				</div>
				<div class="column only-screen">
					<div class="title">Kapcsolat</div>
					<a href="mailto:info@consteach.com">info@consteach.com</a>
				</div>
			</div>
		</footer>
	</div>
</template>

<script>
import LandingHeader from "@/Pages/Landing/Header";

export default {
	components: {
		LandingHeader,
	},
	props: {
		availableLanguages: {
			type: Array,
			default() {
				return [];
			}
		}
	}
}
</script>