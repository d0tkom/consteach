<template>
	<c-pop-up
		:value="value"
		@close="$emit('input', false)"
		title="Az óra még nem vette kezdetét, a videóchat ennyi idő múlva érhető el:"
	>
		<div class="mb-8 text-center text-2xl color-primary-dark">
			<c-date
				class="text-center mb-2 color-gray"
				:value="event.from"
				lesson-start
			/>
		</div>
		<div class="text-center my-4">
			Ha szeretnél üzenetet küldeni tanárodnak azt itt teheted meg:
		</div>
		<div class="actions flex justify-center">
			<c-btn
				outlined
				icon="delete"
				navigate-to="/messages"
			>Üzenet</c-btn>
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
		event: {
			type: Object,
			default() {
				return {
					id: null,
					date: null,
				}
			}
		}
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