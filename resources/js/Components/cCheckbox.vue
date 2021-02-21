<template>
	<div
		class="checkboxContainer cursor-pointer"
		:class="{error}"
		@click="toggle"
	>
		<span class="material-icons checkbox mr-1 text-2xl">{{ data ? 'check_box' : 'check_box_outline_blank' }}</span>
		
		<div
			class="inputLabel"
		>
			<slot />
		</div>
	</div>
</template>

<script>

export default {
	props: {
		value: {
			type: Boolean,
			default: false
		},
		error: {
			type: Boolean,
			default: false
		},
	},
	watch: {
		value(value) {
			this.data = value;
		}
	},
	data: function() {
		return {
			data: this.value
		};
	},
	methods: {
		toggle() {
			this.data = !this.data;
			this.$emit('input', this.data);
		}
	}
}
</script>