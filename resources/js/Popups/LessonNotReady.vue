<template>
	<c-pop-up
		:value="value"
		@close="$emit('input', false)"
		:title="trans.get('dashboard.lesson_not_ready_title')"
	>
		<div class="mb-8 text-center text-2xl color-primary-dark">
			<c-date
				class="text-center mb-2 color-gray"
				:value="event.start"
				lesson-start
			/>
		</div>
		<div class="text-center my-4">
			{{ trans.get('dashboard.lesson_not_ready_description') }}
		</div>
		<div class="actions flex justify-center">
			<c-btn
				outlined
				icon="chat"
				navigate-to="/messages"
			>
				{{ trans.get('dashboard.lesson_not_ready_chat_btn') }}
			</c-btn>
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

	}
}
</script>