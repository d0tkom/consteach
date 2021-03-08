<template>
	<div class="selectContainer" :class="{error}">
		<label>
			<div v-if="label" class="selectLabel">{{ label }}</div>
			<select
				class="w-full"
				:class="{capitalize}"
				@input="event => input(event)"
			>
				<option
					v-if="!notNullable"
					:selected="!value"
				>{{ trans.get('other.select_choose') }}</option>
				<option
					:selected="value === item[valueKey]"
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
		notNullable: {
			type: Boolean,
			default: false
		},
		capitalize: {
			type: Boolean,
			default: false
		},
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
		},
		error: {
			type: Boolean,
			default: false
		}
	},
	methods: {
		input(event) {
			this.$emit('input', event.target.value);
		}
	}
}
</script>