<template>
	<c-pop-up
		:value="active"
		@close="$emit('change-active', false)"
		title="Milyen nyelvet tanulnál?"
	>
		<div class="grid grid-cols-3">
			<div
				class="mb-6 rounded-xl py-2 flex cursor-pointer flex-col items-center justify-center"
				:class="value === language && 'shadow-xl'"
				v-for="language in languages"
				:key="language"
				@click="optionClick(language)"
			>
				<country-flag
					class="flagImg mb-4"
					rounded
					size='big'
					v-if="language"
					:country="language === 'en' ? 'us' : language"
				/>
				<div class="text-center capitalize font-bold text-md mt-4">{{ languageList.getName(language, locale) }}</div>
			</div>
			
			<c-btn
				v-for="(option, o) in options"
				:key="o"
				text
				full
				@click="optionClick(o)"
				class=""
			>{{ option.label }}</c-btn>
		</div>
	</c-pop-up>
</template>

<script>

export default {
	props: {
		locale: {
			type: String
		},
		languageList: {
			type: Object
		},
		languages: {
			type: Array
		},
		active: {
			type: Boolean,
			default: false
		},
		value: {
			type: String,
			default: null
		},
		options: {
			type: Object,
			default() {
				return {};
			}
		}
	},
	methods: {
		optionClick(value) {
			this.$emit('change', value);
			this.$emit('change-active', false);
		}
	}
}
</script>