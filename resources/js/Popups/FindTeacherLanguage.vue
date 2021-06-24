<template>
	<c-pop-up
		:value="active"
		@close="$emit('change-active', false)"
		:title="trans.get('find_teacher.language_filter_popup_title')"
	>
		<div class="languagesGrid grid grid-cols-3">
			<div
				class="languageItem mb-6 rounded-xl py-2 flex cursor-pointer flex-col items-center justify-center"
				:class="value === language && 'selected'"
				v-for="language in languages"
				v-if="language"
				:key="language"
				@click="optionClick(language)"
			>
				<flag
					class="text-6xl rounded-full flagImg mb-4 shadow-sm"
					v-if="language"
					:iso="language === 'en' ? 'us' : language"
				/>
				<div class="itemName text-center capitalize font-bold text-md">{{ languageList.getName(language, locale) }}</div>
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
			if (this.value === value) {
				this.$emit('change', null);
				this.$emit('change-active', false);

				return;
			}

			this.$emit('change', value);
			this.$emit('change-active', false);
		}
	}
}
</script>