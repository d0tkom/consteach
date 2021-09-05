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
					<a
						:href="window.app_url + $page.url"
						class="active"
					>
						<c-btn
							text
							small
						>
							HU
						</c-btn>
					</a>

					<span class="separator mx-2"></span>
					
					<a
						:href="window.app_en_url + $page.url"
						class="active"
					>
						<c-btn
							text
							small
						>
							EN
						</c-btn>
					</a>
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
						<c-btn
							text
							:navigate-to="'/#teach-with-us'"
							class=""
						>
							{{ trans.get('header.teacher_landing_btn') }}
						</c-btn>
					</li>
				</ul>
				<div class="flex items-center authBtns">
					<c-btn
						class="mr-4"
						outlined
						@click="$root.openLoginPopup"
					>
						{{ trans.get('header.login_btn') }}
					</c-btn>
					<c-btn
						@click="$root.openRegistrationPopup()"
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
					<div
						class="walletContainer relative mr-4"
						v-if="!mobileMenu && $page.props.user != null && $page.props.user.role === 'teacher'"
					>
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
					<div>
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
					<!--
					<c-btn
						lg
						:icon-only="!mobileMenu"
						:circle="!mobileMenu"
						text
						class="mr-4"
						icon="chat"
						navigate-to="/messages"
					>{{ trans.get('header.messages_btn') }}</c-btn>
					-->
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
	</header>
</template>

<script>
import Wallet from "@/Widgets/Wallet";
import Logo from '@/Layouts/Partials/Logo';
import ProfilePopup from "@/Widgets/ProfilePopup";

export default {
	components: {
		ProfilePopup,
		Wallet,
		Logo
	},
	data() {
		return {
			window,
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
		logout() {
			axios.post(route('logout').url()).then(response => {
				window.location = '/';
			})
		},
	}
};
</script>