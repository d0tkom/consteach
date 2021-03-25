<template>
	<div class="inputContainer" :class="{error, onlySlot, readonly}">
		<label>
			<div v-if="label" class="inputLabel">{{ label }}</div>
			<input
				:id="inputId"
				:readonly="readonly"
				:autocomplete="autocomplete"
				v-bind:required="required"
				v-bind:autofocus="autofocus"
				:name="name"
				:placeholder="placeholder"
				:value="value"
				@input="$emit('input', $event.target.value)"
				@change="$emit('change', $event.target.value)"
				@keyup="$emit('keyup', $event.target.value)"
				class="w-full"
				:type="type"
			>
			<slot></slot>
		</label>
		<div
			v-if="hint"
			class="flex w-full justify-end items-center color-gray"
		>{{ hint }}</div>
	</div>
</template>

<script>

export default {
	props: {
		inputId: {
			type: String,
			default: null
		},
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
		},
		autocomplete: {
			type: String,
			default: ''
		},
		name: {
			type: String,
			default: ''
		},
		required: {
			type: Boolean,
			default: false
		},
		readonly: {
			type: Boolean,
			default: false
		},
		autofocus: {
			type: Boolean,
			default: false
		},
		hint: {
			type: String,
			default: null
		}
	},
}
</script>