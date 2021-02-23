<template>
	<c-pop-up
		:value="active"
		@close="$emit('change-active', false)"
		title="Milyen nyelvet tanulnál?"
	>
		<div class="grid grid-cols-3">
			<div
				class="flex flex-col items-center justify-center"
				v-for="language in languages"
				:key="language.code"
				@click="optionClick(language.code)"
			>
				<img class="blue-border rounded-full overflow-hidden shadow-md" src="https://via.placeholder.com/80" alt="">
				<div class="text-center mt-2">{{ language.name }}</div>
			</div>
			
			<c-btn
				v-for="(option, o) in options"
				:key="o"
				text
				full
				@click="optionClick(o)"
			>{{ option.label }}</c-btn>
		</div>
	</c-pop-up>
</template>

<script>
import languages from '@/Partials/languages';

export default {
	components: {

	},
	props: {
		active: {
			type: Boolean,
			default: false
		},
		value: {
			type: String,
			default: 'popular'
		},
		options: {
			type: Object,
			default() {
				return {};
			}
		}
	},
	data: function() {
		return {
			languages,
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