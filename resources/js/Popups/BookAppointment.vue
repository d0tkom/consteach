<template>
	<c-pop-up
		:value="value"
		@close="$emit('input', false)"
	>
		<div class="flex flex-col items-center">
			<div class="font-bold text-xl mb-2">{{ data.teacher_name }}</div>
			<div class="date">{{ date }}</div>
			<div class="time text-2xl mb-4">{{ time }}</div>
			<c-btn
				:loading="loading"
				@click="$emit('submit')"
			>{{ trans.get('teacher_profile.lesson_book_btn') }}</c-btn>
		</div>
	</c-pop-up>
</template>

<script>

export default {
	props: {
		value: {
			type: Boolean,
			default: false
		},
		timeZone: {
			type: String,
			default: 'locale'
		},
		loading: {
			type: Boolean,
			default: false
		},
		data: {
			type: Object,
			default() {
				return {
					teacher_name: null,
					date: null
				}
			}
		},
	},
	data: function() {
		return {
			active: this.value,
		};
	},
	computed: {
		date() {
			return this.$moment.utc(this.data.date_start).tz(this.timeZone).format('YYYY. MMMM DD.');
		},
		time() {
			return this.$moment.utc(this.data.date_start).tz(this.timeZone).format('HH:mm');
		}
	},
}
</script>