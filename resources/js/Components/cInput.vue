<template>
	<div class="inputContainer" :class="{error, onlySlot}">
		<label>
			<div v-if="label" class="inputLabel">{{ label }}</div>
			<input
				:placeholder="placeholder"
				:value="value"
				@input="$emit('input', $event.target.value)"
				class="w-full"
				:type="type"
			>
			<slot></slot>
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
		placeholder: {
			type: String,
			default: ''
		},
		error: {
			type: Boolean,
			default: false
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
}
</script>