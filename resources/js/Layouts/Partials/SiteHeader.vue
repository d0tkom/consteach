<template>
	<header>
		<nav v-if="isLanding">
			<inertia-link href="/" class="logo">
				<logo :width="180" :height="60" />
			</inertia-link>
			<button
				class="navbar-toggler"
				:class="menu.opened && 'opened'"
				@click="menu.opened = !menu.opened"
			>
				<span class="line"></span>
				<span class="line"></span>
				<span class="line"></span>
			</button>
			<div
				class="nav-bar"
				:class="menu.opened && 'opened'"
			>
				<div class="lang flex items-center">
					<inertia-link
						:href="$page.url.replace('https://en.', 'https://')"
						class="active"
					>
						<c-btn
							text
							small
						>
							HU
						</c-btn>
					</inertia-link>

					<span class="separator mx-2"></span>
					
					<inertia-link
						:href="$page.url.replace('https://', 'https://en.')"
						class="active"
					>
						<c-btn
							text
							small
						>
							EN
						</c-btn>
					</inertia-link>
				</div>
				<ul class="items-center">
					<li>
						<inertia-link href="/teachers">
							<c-btn
								text
								class=""
								icon="search"
							>
								{{ trans.get('header.find_teacher_btn') }}
							</c-btn>
						</inertia-link>
					</li>
					<li>
						<inertia-link href="/teacher-landing">
							<c-btn
								text
								class=""
							>
								{{ trans.get('header.teacher_landing_btn') }}
							</c-btn>
						</inertia-link>
					</li>
				</ul>
				<div class="flex items-center authBtns">
					<c-btn
						class="mr-4"
						outlined
						@click="$root.popup.login = true"
					>
						{{ trans.get('header.login_btn') }}
					</c-btn>
					<c-btn
						@click="$root.popup.registration = true"
					>
						{{ trans.get('header.register_btn') }}
					</c-btn>
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
				<div class="walletContainer relative mr-4" v-if="$page.props.user != null && $page.props.user.role === 'teacher'">
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
				<div v-if="$page.props.user != null && $page.props.user.role === 'student'">
					<c-btn
						lg
						icon-only
						circle
						text
						class="mr-4"
						icon="search"
						navigate-to="/teachers"
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
			walletOpened: false,
			menu: {
				opened: false
			}
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