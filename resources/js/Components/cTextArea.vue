<template>
	<div class="textAreaContainer" :class="{error, onlySlot}">
		<label>
			<div v-if="label" class="inputLabel">{{ label }}</div>
			<textarea
				@input="$emit('input', $event.target.value)"
				class="w-full"
				:name="name"
				:cols="cols"
				:rows="rows"
				v-model="value_"
			></textarea>
			<div class="bottom flex justify-between items-center">
				<div class="hint" v-show="hint">{{ hint }}</div>
				<div>{{ value_.length }} / {{ max }}</div>
			</div>
		</label>
	</div>
</template>

<script>

export default {
	props: {
		value: {
			default: ''
		},
		label: {
			type: String,
			default: null
		},
		hint: {
			type: String,
			default: null
		},
		error: {
			type: Boolean,
			default: false
		},
		max: {
			type: Number,
			default: 500
		},
		cols: {
			type: Number,
			default: 30
		},
		name: {
			type: String,
			default: 'textarea'
		},
		rows: {
			type: Number,
			default: 6
		},
		onlySlot: {
			type: Boolean,
			default: false
		},
		type: {
			type: String,
			default: 'text'
		}
	},
	data: function() {
		return {
			value_: this.value
		};
	}
}
</script>