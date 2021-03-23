<template>
	<c-pop-up
		:value="value"
		@close="$emit('input', false)"
		:title="trans.get('dashboard.lesson_cancel_title')"
	>
		<div class="eventContainer flex justify-between mb-8">
			<div class="profileImageWrapper mr-4">
				<img
					class="max-w-none blue-border rounded-full overflow-hidden"
					:src="event.teacher.profile_image"
					alt="Tanár képe"
				>
			</div>
			<div class="w-full flex flex-col">
				<div class="name text-2xl font-bold color-primary-dark mb-2">
					{{ event.teacher.name }}
				</div>
				<div class="color-primary font-bold mb-2">
					{{ event.language }} {{ trans.get('dashboard.lesson_cancel_hour') }} ({{ event.length }} {{ trans.get('dashboard.lesson_cancel_minute') }})
				</div>
				<div>
					<c-date
						with-day
						:value="event.date"
					/>
				</div>
				<c-date
					class="text-2xl font-bold color-primary-dark"
					only-time
					:value="event.date"
				/>
			</div>
		</div>
		
		<div class="actions flex justify-center">
			<c-btn
				color="error"
				outlined
				icon="cancel"
				:loading="loading"
			>{{ trans.get('dashboard.lesson_cancel_btn') }}</c-btn>
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
					teacher: {
						profile_image: null,
						name: null
					},
					language: null,
					length: null,
					date: null
				};
			}
		}
	},
	data: function() {
		return {
			active: this.value,
			loading: false,
		};
	}
}
</script>