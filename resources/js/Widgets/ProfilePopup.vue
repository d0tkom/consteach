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
			{{ trans.get($page.props.user.role === 'teacher' ? 'header.teacher_hub_btn' : 'header.student_hub_btn') }}
		</c-btn>
		<!--
		<c-btn
			full
			class="mb-2"
			text
			align-left
			icon="dark_mode"
		>
			{{ trans.get('header.dark_mode_btn') }}
		</c-btn>
		-->
		<c-btn
			full
			align-left
			class="mb-2"
			text
			icon="settings"
			navigate-to="/settings"
		>
			{{ trans.get('header.settings_btn') }}
		</c-btn>
		<c-btn
			full
			text
			align-left
			icon="logout"
			@click.prevent="logout"
		>
			{{ trans.get('header.logout_btn') }}
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