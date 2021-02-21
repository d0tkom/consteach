<template>
	<c-pop-up
		:value="active"
		@close="$emit('change-active', false)"
		title="Milyen óradíjjal keresel tanárt? Jelöld be a csúszkán!"
	>
		<div class="valueContainer flex items-center justify-between text-2xl font-bold relative">
			<div>{{ value[0] }} HUF</div>
			<span class="separator">-</span>
			<div>{{ value[1] }} HUF</div>
		</div>
		<vue-slider
			:value="value"
			:min="1500"
			:max="15000"
			:interval="100"
			tooltip="none"
			@change="value => $emit('change', value)"
		/>
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
			type: Array,
			default() {
				return [0,0];
			}
		}
	},
	data: function() {
		return {
		
		};
	},
	methods: {
		optionClick(value) {
			this.$emit('change', value);
			this.$emit('change-active', false);
		}
	}
}
</script>