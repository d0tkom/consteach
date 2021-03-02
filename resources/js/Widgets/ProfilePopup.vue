<template>
	<div
		class="profilePopupWidget shadow-lg p-2 bg-white blue-border flex flex-col justify-between items-center"
	>
		<c-btn
			full
			icon="home"
			class="mb-2"
			text
			align-left
			navigate-to="/dashboard"
		>
			{{ $page.props.user.role == 'teacher' ? 'Oktatótér' : 'Tanulótér' }}
		</c-btn>
		<c-btn
			full
			class="mb-2"
			text
			align-left
			icon="dark_mode"
		>
			Éjjeli mód
		</c-btn>
		<c-btn
			full
			align-left
			class="mb-2"
			text
			icon="settings"
			navigate-to="/settings"
		>
			Beállítások
		</c-btn>
		<c-btn
			full
			text
			align-left
			icon="logout"
			@click.prevent="logout"
		>
			Kijelentkezés
		</c-btn>
	</div>
</template>

<script>

export default {
	props: {
		value: {
			type: Boolean,
			default: false
		},
	},
	data() {
		return {
			opened: false,
			clickListener: null
		};
	},
	watch: {
		value(value) {
			this.opened = value;
		},
	},
	methods: {
		onClose() {
			if (this.opened) {
				this.opened = false;
				this.$emit('input', false);
			}
		},
		logout() {
            axios.post(route('logout').url()).then(response => {
                window.location = '/';
            })
        },
	}
}
</script>