<template>
	<c-pop-up
		:value="active"
		@close="$emit('change-active', false)"
		title="Milyen óradíjjal keresel tanárt? Jelöld be a csúszkán!"
	>
		<div class="valueContainer flex items-center justify-between text-2xl font-bold relative">
			<div>{{ value_[0] }} HUF</div>
			<span class="separator">-</span>
			<div>{{ value_[1] }} HUF</div>
		</div>
		<vue-slider
			v-model="value_"
			:min="0"
			:max="15000"
			:interval="100"
			tooltip="none"
		/>
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
			type: Array,
			default() {
				return [0,0];
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
			value_: this.value
		};
	},
	methods: {
		submit() {
			this.$emit('change', this.value_);
			this.$emit('change-active', false);
		}
	}
}
</script>