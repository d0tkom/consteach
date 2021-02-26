<template>
	<div class="inputContainer">
		<label>
			<div v-if="label" class="selectLabel">{{ label }}</div>
			<select
				class="w-full"
				@input="event => input(event)"
			>
				<option
					:selected="!value"
				>Válassz</option>
				<option
					:selected="value == item[valueKey]"
					:value="item[valueKey]"
					v-for="(item, i_) in data"
					:key="i_"
				>
					{{ item[labelKey] }}
				</option>
			</select>
		</label>
	</div>
</template>

<script>

export default {
	props: {
		label: {
			type: String,
			default: null
		},
		data: {
			type: Array|Object,
			default: []
		},
		labelKey: {
			type: String,
			default: 'name'
		},
		valueKey: {
			type: String,
			default: 'code'
		},
		value: {
			type: String,
			default: null
		}
	},
	methods: {
		input(event) {
			console.log(event)
			this.$emit('input', event.target.value);
		}
	}
}
</script>