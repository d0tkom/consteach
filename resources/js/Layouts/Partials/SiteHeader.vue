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
		<div v-else class="headerContainer loggedInHeaderContainer flex justify-between items-center">
			<inertia-link
				href="/"
			>
				<logo />
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
			<nav class="flex items-center justify-between">
				<div
					class="nav-bar"
					:class="menu.opened && 'opened'"
				>
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
					<c-btn
						v-if="mobileMenu"
						lg
						:icon-only="!mobileMenu"
						:circle="!mobileMenu"
						text
						class="mr-4"
						icon="home"
						navigate-to="/dashboard"
					>
						{{ trans.get($page.props.user.role === 'teacher' ? 'header.teacher_hub_btn' : 'header.student_hub_btn') }}
					</c-btn>
					<div v-if="$page.props.user != null && $page.props.user.role === 'student'">
						<c-btn
							lg
							:icon-only="!mobileMenu"
							:circle="!mobileMenu"
							text
							class="mr-4"
							icon="search"
							navigate-to="/teachers"
						>{{ trans.get('header.find_teacher_btn') }}</c-btn>
					</div>
					<c-btn
						lg
						:icon-only="!mobileMenu"
						:circle="!mobileMenu"
						text
						class="mr-4"
						icon="chat"
						navigate-to="/messages"
					>{{ trans.get('header.messages_btn') }}</c-btn>
					<!--
					<c-btn
						lg
						:icon-only="!mobileMenu"
						:circle="!mobileMenu"
						text
						class="mr-4"
						icon="notifications"
					>{{ trans.get('header.notifications_btn') }}</c-btn>
					-->
					<div v-if="mobileMenu">
						<!--
						<c-btn
							lg
							:icon-only="!mobileMenu"
							:circle="!mobileMenu"
							text
							class="mr-4"
							icon="dark_mode"
						>
							{{ trans.get('header.dark_mode_btn') }}
						</c-btn>
						-->
						<c-btn
							lg
							:icon-only="!mobileMenu"
							:circle="!mobileMenu"
							text
							class="mr-4"
							icon="settings"
							navigate-to="/settings"
						>
							{{ trans.get('header.settings_btn') }}
						</c-btn>
						<c-btn
							lg
							:icon-only="!mobileMenu"
							:circle="!mobileMenu"
							text
							class="mr-4"
							icon="logout"
							@click.prevent="logout"
						>
							{{ trans.get('header.logout_btn') }}
						</c-btn>
					</div>
					
					<div v-else class="profilePopupContainer relative">
						<c-btn
							lg
							:icon-only="!mobileMenu"
							:circle="!mobileMenu"
							text
							icon="account_circle"
						>{{ trans.get('header.profile_btn') }}</c-btn>
						<profile-popup />
					</div>
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
		mobileMenu() {
			return this.$root.viewport.w <= 1200;
		},
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