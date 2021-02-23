<template>
	<header>
		<div class="headerContainer flex justify-between items-center">
			<inertia-link
				href="/"
			>
				<logo />
			</inertia-link>
			<nav class="hidden sm:flex items-center justify-between">
				<div class="walletContainer relative mr-4" v-if="$page.props.user.role == 'teacher'">
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
			walletOpened: false
		};
	},
	methods: {
		walletClose() {
			this.walletOpened = false
		},
	}
};

</script>