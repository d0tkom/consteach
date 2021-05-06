<template>
	<c-pop-up
		large
		:value="active"
		@close="$emit('change-active', false)"
		:title="trans.get('find_teacher.day_popup_title')"
	>
		<div class="color-gray text-center">{{ trans.get('find_teacher.day_popup_time_of_day') }}</div>
		<div class="daysContainer mb-4 p-1 rounded-md blue-border flex items-center justify-between font-bold relative">
			<c-btn
				small
				v-for="(timeOfDay, t) in timeOfDays"
				:key="t"
				:text="value_.timeOfDay.indexOf(timeOfDay.value) === -1"
				@click="timeOfDayToggle(timeOfDay.value)"
			>{{ timeOfDay.label }}</c-btn>
		</div>
		<div class="color-gray text-center">{{ trans.get('find_teacher.day_popup_day') }}</div>
		<div class="daysContainer p-1 rounded-md blue-border flex items-center justify-between font-bold relative">
			<c-btn
				v-for="(day, d) in days"
				:key="d"
				:text="value_.day.indexOf(day.value) === -1"
				@click="dayToggle(day.value)"
			>{{ day.label }}</c-btn>
		</div>
		<div class="flex justify-center mt-4">
			<c-btn
				@click="submit"
			>{{ trans.get('find_teacher.day_popup_filter_btn') }}</c-btn>
		</div>
	</c-pop-up>
</template>

<script>
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/antd.css'

export default {
	components: {
		VueSlider
	},
	props: {
		active: {
			type: Boolean,
			default: false
		},
		value: {
			type: Object,
			default() {
				return {
					timeOfDay: [],
					day: []
				};
			}
		}
	},
	watch: {
		value(value) {
			this.value_ = value;
		}
	},
	data: function() {
		return {
			value_: this.value,
			days: [
				{
					label: this.trans.get('find_teacher.day_popup_day_0_label'),
					value: 0
				}, {
					label: this.trans.get('find_teacher.day_popup_day_1_label'),
					value: 1
				}, {
					label: this.trans.get('find_teacher.day_popup_day_2_label'),
					value: 2
				}, {
					label: this.trans.get('find_teacher.day_popup_day_3_label'),
					value: 3
				}, {
					label: this.trans.get('find_teacher.day_popup_day_4_label'),
					value: 4
				}, {
					label: this.trans.get('find_teacher.day_popup_day_5_label'),
					value: 5
				}, {
					label: this.trans.get('find_teacher.day_popup_day_6_label'),
					value: 6
				}
			],
			timeOfDays: [
				{
					label: '00:00 - 06:00',
					value: {start: '00:00', end: '06:00'}
				}, {
					label: '06:00 - 12:00',
					value: {start: '06:00', end: '12:00'}
				}, {
					label: '12:00 - 18:00',
					value: {start: '12:00', end: '18:00'}
				}, {
					label: '18:00 - 24:00',
					value: {start: '18:00', end: '24:00'}
				}
			]
		};
	},
	methods: {
		submit() {
			this.$emit('change-time-of-day', this.value_.timeOfDay);
			this.$emit('change-day', this.value_.day);
			this.$emit('input', this.value_);
		},
		timeOfDayToggle(value) {
			let valueIndex = this.value_.timeOfDay.indexOf(value);
			if (valueIndex === -1) {
				this.value_.timeOfDay.push(value);
			} else {
				this.$delete(this.value_.timeOfDay, valueIndex);
			}
		},
		dayToggle(value) {
			let valueIndex = this.value_.day.indexOf(value);
			if (valueIndex === -1) {
				this.value_.day.push(value);
			} else {
				this.$delete(this.value_.day, valueIndex);
			}
		}
	}
}
</script>