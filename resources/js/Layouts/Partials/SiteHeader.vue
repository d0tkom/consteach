<template>
	<header>
		<nav v-if="isLanding">
			<inertia-link href="/" class="logo">
				<logo :width="180" :height="60" />
			</inertia-link>
			<button class="navbar-toggler">
				<span class="line"></span>
				<span class="line"></span>
				<span class="line"></span>
			</button>
			<div class="nav-bar">
				<div class="lang">
					<a :href="route(route().current()).replace('http://en.', 'http://')" class="active">HU</a>
					<span class="separator"></span>
					<a :href="route(route().current()).replace('http://', 'http://en.')">EN</a>
				</div>
				<ul>
					<li>
						<inertia-link href="/teachers">Tanárt keresek</inertia-link>
					</li>
					<li>
						<inertia-link href="/teacher-landing">Jelentkezem tanárnak</inertia-link>
					</li>
					<li class="display-mode">
						<inertia-link href="">Éjjeli mód</inertia-link>
						<div class="switch-container">
							<label class="switch">
								<input type="checkbox">
								<span class="slider round"></span>
							</label>
						</div>
					</li>
				</ul>
				<div class="flex items-center authBtns">
					<c-btn
						class="mr-4"
						outlined
						@click="$root.popup.login = true"
					>Bejelentkezés</c-btn>
					<c-btn
						@click="$root.popup.registration = true"
					>Regisztráció</c-btn>
				</div>
			</div>
		</nav>
		<div v-else class="headerContainer flex justify-between items-center">
			<inertia-link
				href="/"
			>
				<logo />
			</inertia-link>
			<nav class="hidden sm:flex items-center justify-between">
				<div class="walletContainer relative mr-4" v-if="$page.props.user != null && $page.props.user.role == 'teacher'">
					<c-btn
						lg
						icon-only
						circle
						text
						icon="account_balance_wallet"
						@click="walletOpened = !walletOpened"
						v-on-click-outside="walletClose"
					/>
					<wallet
						v-model="walletOpened"
					/>
				</div>
				<c-btn
					lg
					icon-only
					circle
					text
					class="mr-4"
					icon="chat"
					navigate-to="/messages"
				/>
				<c-btn
					lg
					icon-only
					circle
					text
					class="mr-4"
					icon="notifications"
				/>
				<div class="profilePopupContainer relative">
					<c-btn
						lg
						icon-only
						circle
						text
						icon="account_circle"
					/>
					<profile-popup />
				</div>
			</nav>
		</div>
		
		<login-popup v-model="$root.popup.login" />
		<register-popup v-model="$root.popup.registration" />
		<lost-password-popup v-model="$root.popup.lostPassword" />
	</header>
</template>

<script>
import Wallet from "@/Widgets/Wallet";
import Logo from '@/Layouts/Partials/Logo';
import ProfilePopup from "@/Widgets/ProfilePopup";
import LoginPopup from "@/Pages/Landing/LoginPopup";
import RegisterPopup from "@/Pages/Landing/RegisterPopup";
import LostPasswordPopup from "@/Pages/Landing/LostPasswordPopup";

export default {
	components: {
		LostPasswordPopup,
		RegisterPopup,
		LoginPopup,
		ProfilePopup,
		Wallet,
		Logo
	},
	data() {
		return {
			walletOpened: false
		};
	},
	computed: {
		isLanding() {
			return this.$page.props.user === null;
		}
	},
	methods: {
		walletClose() {
			this.walletOpened = false
		},
	}
};

</script>