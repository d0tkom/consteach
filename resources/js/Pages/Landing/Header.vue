<template>
	<header>
		<nav>
			<a href="#" class="logo">
				<logo :width="180" :height="60" />
			</a>
			<button class="navbar-toggler">
				<span class="line"></span>
				<span class="line"></span>
				<span class="line"></span>
			</button>
			<div class="nav-bar">
				<div class="lang">
					<a href="" class="active">HU</a>
					<span class="separator"></span>
					<a href="">EN</a>
				</div>
				<ul>
					<li>
						<a href="/find-teacher">Tanárt keresek</a>
					</li>
					<li>
						<a href="">Jelentkezem tanárnak</a>
					</li>
					<li class="display-mode">
						<a href="">Éjjeli mód</a>
						<div class="switch-container">
							<label class="switch">
								<input type="checkbox">
								<span class="slider round"></span>
							</label>
						</div>
					</li>
					<li>
						<a href="">Segítség</a>
					</li>
				</ul>
				<div class="flex items-center authBtns">
					<c-btn
						class="mr-4"
						outlined
						@click="popup.login = true"
					>Bejelentkezés</c-btn>
					<c-btn
						@click="popup.registration = true"
					>Regisztráció</c-btn>
				</div>
			</div>
		</nav>
		<login-popup v-model="popup.login" />
		<register-popup v-model="popup.registration" />
		<lost-password-popup v-model="popup.lostPassword" />
	</header>
</template>

<script>
import LoginPopup from '@/Pages/Landing/LoginPopup';
import RegisterPopup from '@/Pages/Landing/RegisterPopup';
import LostPasswordPopup from '@/Pages/Landing/LostPasswordPopup';
import Logo from '@/Layouts/Partials/Logo';

export default {
	components: {
		LoginPopup,
		RegisterPopup,
		LostPasswordPopup,
		Logo
	},
	data() {
		return {
			popup: {
				login: false,
				registration: false,
				lostPassword: false
			}
		}
	},
	mounted() {
		if (window.location.hash === '#login') {
			this.popup.login = true;
		}
		
		if (window.location.hash === '#registration') {
			this.popup.registration = true;
		}
		
		if (window.location.hash === '#lost-password') {
			this.popup.lostPassword = true;
		}
	}
}
</script>

<style scoped>

</style>