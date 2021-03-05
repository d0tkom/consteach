<template>
	<c-pop-up
		large
		:value="active"
		@close="$emit('change-active', false)"
		title="Szűrj nap vagy napszak alapján!"
	>
		<div class="color-gray text-center">Napszak</div>
		<div class="daysContainer mb-4 p-1 rounded-md blue-border flex items-center justify-between font-bold relative">
			<c-btn
				small
				v-for="(timeOfDay, t) in timeOfDays"
				:key="t"
				:text="value_.timeOfDay.indexOf(timeOfDay.value) === -1"
				@click="timeOfDayToggle(timeOfDay.value)"
			>{{ timeOfDay.label }}</c-btn>
		</div>
		<div class="color-gray text-center">Nap</div>
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
			>Szűrés</c-btn>
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
					label: 'Hé',
					value: 0
				}, {
					label: 'Ke',
					value: 1
				}, {
					label: 'Sze',
					value: 2
				}, {
					label: 'Csü',
					value: 3
				}, {
					label: 'Pé',
					value: 4
				}, {
					label: 'Szo',
					value: 5
				}, {
					label: 'Va',
					value: 6
				}
			],
			timeOfDays: [
				{
					label: '04:00 - 08:00',
					value: {start: '04:00', end: '08:00'}
				}, {
					label: '09:00 - 11:00',
					value: {start: '09:00', end: '11:00'}
				}, {
					label: '12:00 - 18:00',
					value: {start: '12:00', end: '18:00'}
				}, {
					label: '19:00 - 03:00',
					value: {start: '19:00', end: '03:00'}
				}
			]
		};
	},
	methods: {
		submit() {
			this.$emit('change-time-of-day', this.value_.timeOfDay);
			this.$emit('change-day', this.value_.day);
			this.$emit('input', false);
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