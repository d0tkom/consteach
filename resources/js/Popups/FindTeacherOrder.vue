<template>
	<c-pop-up
		:value="active"
		@close="$emit('change-active', false)"
		title="Milyen elv szerint rendezzük sorba a tanárokat?"
	>
		<div>
			<c-btn
				class="mb-4"
				v-for="(option, o) in options"
				:key="o"
				:text="value !== o"
				full
				@click="optionClick(o)"
			>{{ option.label }}</c-btn>
		</div>
	</c-pop-up>
</template>

<script>

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