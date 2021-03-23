<template>
	<div class="sliderContainer" :class="{error}">
		<label>
			<div v-if="label" class="inputLabel">{{ label }}</div>
			<div>
				<div class="value text-center">
					<currency
						:value="data"
					/>
				</div>
				<input
					v-model="data"
					@input="$emit('input', $event.target.value)"
					type="range"
					:min="min"
					:max="max"
				>
			</div>
		</label>
	</div>
</template>

<script>

export default {
	props: {
		value: {
			default: 0
		},
		label: {
			type: String,
			default: null
		},
		error: {
			type: Boolean,
			default: false
		},
		min: {
			type: Number,
			default: 0
		},
		max: {
			type: Number,
			default: 1000000
		}
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
		input(value) {
			this.$emit('input', value.data);
		}
	}
}
</script>