<template>
	<c-pop-up
		:value="value"
		@close="$emit('input', false)"
		title="Biztosan törölni szeretnéd a fiókodat?"
	>
		<div class="actions flex justify-center">
			<c-btn
				color="error"
				outlined
				@click="deleteProfile"
				icon="delete"
				:loading="loading"
			>Törlés</c-btn>
		</div>
	</c-pop-up>
</template>

<script>

export default {
	components: {

	},
	props: {
		value: {
			type: Boolean,
			default: false
		},
	},
	data: function() {
		return {
			active: this.value,
			loading: false,
		};
	},
	methods: {
		deleteProfile() {
			console.warn('TODO:Remove user...');
			this.loading = true;
			
			setTimeout(() => {
				this.loading = false;
			}, 2000);
		}
	}
}
</script>